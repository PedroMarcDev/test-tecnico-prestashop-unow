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

class Cookiesbanner extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'cookiesbanner';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'PedroMarcDev';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Banner de cookies');
        $this->description = $this->l('Muestra un banner de uso de cookies en la web al usuario que accede a la misma.');

        $this->confirmUninstall = $this->l('¿Seguro que deseas desinstalar este modulo?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('COOKIESBANNER_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayFooterAfter');
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
        if (((bool)Tools::isSubmit('submitBannerConfig')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign([
            'title' => Configuration::get('banner_title'),
            'content' => Configuration::get('banner_content'),
            'txt_color' => Configuration::get('banner_text_color'),
            'bg_color' => Configuration::get('banner_background_color'),
            'txt_btn_accept' => Configuration::get('accept_btn_txt'),
            'txt_btn_refuse' => Configuration::get('refuse_btn_txt'),
            'accept_txt_color' => Configuration::get('accept_text_color'),
            'refuse_txt_color' => Configuration::get('refuse_text_color'),
            'accept_bg_color' => Configuration::get('accept_bg_color'),
            'refuse_bg_color' => Configuration::get('refuse_bg_color'),
            'banner_position' => Configuration::get('banner_position'),
        ]);

        $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');

        return $output;
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        if (((bool)Tools::isSubmit('submitBannerConfig')) == true) {
            $defaults = [
                'banner_title' => $this->l('Bienvenido al Módulo de Banner de Cookies'),
                'banner_content' => $this->l('Utilizamos cookies para mejorar su experiencia en nuestro sitio web.'),
                'banner_text_color' => '#ffffff',
                'banner_background_color' => '#000000',
                'accept_btn_txt' => $this->l('Aceptar'),
                'refuse_btn_txt' => $this->l('Rechazar'),
                'accept_text_color' => '#ffffff',
                'refuse_text_color' => '#ffffff',
                'accept_bg_color' => '#28a745',
                'refuse_bg_color' => '#dc3545',
                'banner_position' => 'bottom'
            ];

            $configValues = [];
            foreach ($defaults as $key => $defaultValue) {
                $submittedValue = Tools::getValue($key);
                $configValues[$key] = empty($submittedValue) ? $defaultValue : $submittedValue;
            }

            foreach ($configValues as $key => $value) {
                Configuration::updateValue($key, $value);
            }

            $this->context->controller->confirmations[] = $this->l('Banner configurado correctamente');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
            $this->context->controller->addJS(_PS_JS_DIR_ . 'tiny_mce/tiny_mce.js');
            $this->context->controller->addJS(_PS_JS_DIR_ . 'admin/tinymce.inc.js');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/front.css');
    }

    public function hookDisplayFooterAfter()
    {
        $this->context->smarty->assign([
            'title' => Configuration::get('banner_title'),
            'content' => Configuration::get('banner_content'),
            'txt_color' => Configuration::get('banner_text_color'),
            'bg_color' => Configuration::get('banner_background_color'),
            'txt_btn_accept' => Configuration::get('accept_btn_txt'),
            'txt_btn_refuse' => Configuration::get('refuse_btn_txt'),
            'accept_txt_color' => Configuration::get('accept_text_color'),
            'refuse_txt_color' => Configuration::get('refuse_text_color'),
            'accept_bg_color' => Configuration::get('accept_bg_color'),
            'refuse_bg_color' => Configuration::get('refuse_bg_color'),
            'banner_position' => Configuration::get('banner_position'),
        ]);

        return $this->display(__FILE__, '/views/templates/hook/displayFooterAfter.tpl');
    }
}
