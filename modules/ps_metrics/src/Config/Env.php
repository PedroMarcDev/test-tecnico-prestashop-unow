<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
namespace PrestaShop\Module\Ps_metrics\Config;

use ps_metrics_module_v4_1_2\Dotenv\Dotenv;
/**
 * This class allows to retrieve config data that can be overwritten by a .env file.
 * Otherwise it returns by default from the Config class.
 */
class Env
{
    public function __construct(\Ps_metrics $module)
    {
        if (\file_exists(_PS_MODULE_DIR_ . $module->name . '/.env')) {
            $dotenv = Dotenv::create(_PS_MODULE_DIR_ . $module->name . '/');
            $dotenv->load();
        }
    }
    /**
     * @param string $key
     *
     * @return string
     */
    public function get($key)
    {
        if (!empty($_ENV[$key])) {
            return $_ENV[$key];
        }
        //TODO implement config class
        //return constant(Config::class . '::' . $key);
        return '';
    }
}
