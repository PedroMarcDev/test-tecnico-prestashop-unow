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

class Weatherinfo extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'weatherinfo';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'PedroMarcDev';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Información del Clima');
        $this->description = $this->l('Permite obtener datos climatologicos de la zona donde se encuentra el usuario y mostrarlos dentro de la tienda.');

        $this->confirmUninstall = $this->l('¿Seguro que deseas desinstalar este modulo?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('WEATHERINFO_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayNavFullWidth');
    }

    public function uninstall()
    {
        Configuration::deleteByName('WEATHERINFO_LIVE_MODE');

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
        if (((bool)Tools::isSubmit('submitApisKey')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign(['apikey' => Configuration::get('apikey'), 'geokey' => Configuration::get('geokey')]);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output;
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        if (((bool)Tools::isSubmit('submitApisKey')) == true) {
            
            if(empty(Tools::getValue('apikey')) || empty(Tools::getValue('geokey'))) {
                $this->context->controller->errors[] = $this->l('Por favor ingresa las API keys solicitadas para continuar');
            }
            else {
                Configuration::updateValue('apikey', Tools::getValue('apikey'));
                Configuration::updateValue('geokey', Tools::getValue('geokey'));
                $this->context->controller->confirmations[] = $this->l('APIs Keys guardadas correctamente');
            }
        }
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

    public function hookDisplayNavFullWidth() {

        $user_ip = file_get_contents('https://api.ipify.org');

        if($user_ip) {
            $localization = $this->getUserLocalization($user_ip);

            $weatherData = $this->getUserWeather($localization);

            $city = $weatherData['name'];
            $country_code = $weatherData['sys']['country'];
            $weather = $weatherData['weather'][0]['description'];
            $weather_icon = $weatherData['weather'][0]['icon'];
            $temp = $weatherData['main']['temp'];
            $feels_like = $weatherData['main']['feels_like'];
            $humidity = $weatherData['main']['humidity'];

            // die(var_dump($weatherData));

            $this->context->smarty->assign(['city' => $city, 'country' => $country_code, 'weather' => $weather, 'temp' => $temp, 'humidity' => $humidity, 'feels_like' => $feels_like, 'weather_icon' => $weather_icon, 'data_weather' => $weatherData]);
        }
        
        return $this->display(__FILE__, '/views/templates/hook/displayNavFullWidth.tpl');
    }

    public function getUserLocalization($ip) {

        //$cacheIp = 'user_ip_' . md5($ip);

        $geoApiKey = Configuration::get('geokey');

        $url = 'https://api.ipgeolocation.io/ipgeo?apiKey='.$geoApiKey.'&ip='.$ip;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response, true);

        if ($data) {
            return [
                'country_code' => $data['country_code2'],
                'city' => rawurlencode($data['city']),
                'region' => rawurlencode($data['state_prov'])
            ];
        }
        
        return [];
    }

    public function getUserWeather($local) {

        //$cacheUserWeather = 'user_weather_' . md5($local);

        $weatherApiKey = Configuration::get('apikey');

        $weatherEndpoint = 'https://api.openweathermap.org/data/2.5/weather?';

        $query = 'q='.$local['city'].','.$local['country_code'];

        $shop_lang = Context::getContext()->language->iso_code;

        $url = $weatherEndpoint.$query.'&APPID='.$weatherApiKey.'&units=metric&lang='.$shop_lang;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response, true);

        return $data;
    }
}
