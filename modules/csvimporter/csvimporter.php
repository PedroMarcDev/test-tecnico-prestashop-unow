<?php
/**
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Csvimporter extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'csvimporter';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'PedroMarcDev';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Importar productos por CSV');
        $this->description = $this->l('Un modulo que permite importar productos a su web por medio de un CSV.');

        $this->confirmUninstall = $this->l('¿Seguro que deseas desinstalar este modulo?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('CSVIMPORTER_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submit_csv')) == true) {

            $this->postProcess();
        }

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output;
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        if (((bool)Tools::isSubmit('submit_csv')) == true) {

            $csv = array();
            $csv['name'] = $_FILES['csv_product']['name'];
            $csv['type'] = $_FILES['csv_product']['type'];
            $csv['tmp_name'] = $_FILES['csv_product']['tmp_name'];
            $csv['error'] = $_FILES['csv_product']['error'];
            $csv['size'] = $_FILES['csv_product']['size'];

            $extension = pathinfo($csv['name'], PATHINFO_EXTENSION);

            if(empty($csv["tmp_name"])) {
                $this->context->controller->errors[] = $this->l('Por favor, selecciona un archivo CSV para poder continuar');
            }

            if(strtolower($extension) != 'csv') {
                $this->context->controller->errors[] = $this->l('El archivo debe ser en formato CSV (.csv)');
            }

            $this->processCSV($csv);

        }
    }

    public function processCSV($csv) 
    {
        $handle = fopen($csv['tmp_name'], "r");

        $csvHeaders = fgetcsv($handle, 0, ",");

        $contentCsv = [];

        while ($row = fgetcsv($handle)) {
            $head = array_combine($csvHeaders, $row);
            $contentCsv[] = $head;
        }

        foreach($contentCsv as $product) {
            $ivaSql = "SELECT id_tax FROM "._DB_PREFIX_."tax WHERE rate = ".$product['IVA']."";
            $iva = Db::getInstance()->executeS($ivaSql);

            $manufacturer = $this->handleManufacturer($product['Marca']);

            $categories = $this->handleCategories($product['Categorias']);

            $productSql = "SELECT id_product FROM "._DB_PREFIX_."product WHERE reference = ".$product['Referencia']."";
            $checkProductExists = Db::getInstance()->executeS($productSql);

            if(!$checkProductExists) {
                $newProduct = new Product();
                $newProduct->name = array((int)Configuration::get('PS_LANG_DEFAULT') => $product['Nombre']);
                $newProduct->reference = $product['Referencia'];
                $newProduct->ean13 = $product['EAN13'];
                $newProduct->wholesale_price = (float)$product['Precio de coste'];
                $newProduct->price = (float)$product['Precio de venta'];
                $newProduct->id_tax_rules_group = (int)$iva[0]['id_tax'];
                $newProduct->id_manufacturer = (int)$manufacturer;
                $newProduct->id_category_default = $categories[0];
                $newProduct->add();
                StockAvailable::setQuantity($newProduct->id, 0, (int)$product['Cantidad']);
                $newProduct->addToCategories($categories); 
            }
            else {              
                $productUpdate = new Product((int)$checkProductExists[0]['id_product']);
                $productUpdate->reference = $product['Referencia'];
                $productUpdate->ean13 = $product['EAN13'];
                $productUpdate->wholesale_price = (float)$product['Precio de coste'];
                $productUpdate->price = (float)$product['Precio de venta'];
                $productUpdate->id_tax_rules_group = (int)$iva[0]['id_tax'];
                $productUpdate->id_manufacturer = (int)$manufacturer;
                $productUpdate->id_category_default = $categories[0];
                $productUpdate->update();
                StockAvailable::updateQuantity($productUpdate->id, 0, $product['Cantidad'], null, true);

            }
        }

        $this->context->controller->confirmations[] = $this->l('Importación completada con éxito');

    }

    public function handleManufacturer($brand) 
    {

        $brandSql = "SELECT id_manufacturer FROM "._DB_PREFIX_."manufacturer WHERE name = '".$brand."'";

        $checkBrandExists = Db::getInstance()->executeS($brandSql);

        if (!$checkBrandExists) {
            $newManufacturer = new Manufacturer();
            $newManufacturer->name = $brand;
            $newManufacturer->active = 1;
            $newManufacturer->add();

            return $newManufacturer->id;

        }else{
            return $checkBrandExists[0]['id_manufacturer'];
        }
    }

    public function handleCategories($cat) 
    {
        $categories = explode(';', $cat);

        $productCategories[] = array();

        foreach($categories as $key => $category) {

            $catSql = "SELECT id_category FROM "._DB_PREFIX_."category_lang WHERE name = '".$category."'";

            $checkCategoryExists = Db::getInstance()->executeS($catSql);

            if (!$checkCategoryExists) {
                $formattedCat = strtr($category, " ", "-");
                $newCatFormatter = str_replace(",", "", $formattedCat);
                $newCategory = new Category();
                $newCategory->name = array((int)Configuration::get('PS_LANG_DEFAULT') => $category);
                $newCategory->id_shop_default = 1;
                $newCategory->id_parent = Configuration::get('PS_HOME_CATEGORY');
                $newCategory->link_rewrite = array((int)Configuration::get('PS_LANG_DEFAULT') => $this->sanitizeCategories(($newCatFormatter)));
                $newCategory->position = (int) Category::getLastPosition((int) Configuration::get('PS_HOME_CATEGORY'), 1);
                $newCategory->add();
    
                $productCategories[$key] = (int)$newCategory->id;
    
            }else{
                $productCategories[$key] = (int)$checkCategoryExists[0]['id_category'];
            }
        }

        return $productCategories;
    }

    public function sanitizeCategories($name)
    {
        $cat = $name;

        $cat = str_replace(
            array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'),
            array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N'),
            $cat
        );

        $cat = preg_replace('/[^a-zA-Z0-9\s]/', '', $cat);

        $cat = preg_replace('/\s+/', ' ', $cat);
    
        return $cat;
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }
}
