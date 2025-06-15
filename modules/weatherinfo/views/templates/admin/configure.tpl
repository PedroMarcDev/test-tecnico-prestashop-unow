{*
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
*}

<form class="defaultForm form-horizontal" action="" method="post" enctype="multipart/form-data">
	<div class="panel">
		<div class="form-group">

			<label class="control-label col-lg-3 required">

				{l s='Añadir APIKey de OpenWeatherMap' mod='weatherinfo'}

			</label>

			<div class="col-lg-9">

				<input type="text" name="apikey" id="apikey" value="{$apikey}" class="" size="20">

				<p class="help-block">

					{l s='APIKey de OpenWeatherMap' mod='weatherinfo'}

				</p>

			</div>

			<label class="control-label col-lg-3 required">

				{l s='Añadir APIKey de IPGeolocation' mod='weatherinfo'}

			</label>

			<div class="col-lg-9">

				<input type="text" name="geokey" id="geokey" value="{$geokey}" class="" size="20">

				<p class="help-block">

					{l s='APIKey de IPGeolocation' mod='weatherinfo'}

				</p>

			</div>

			<div class="">

				<button type="submit" value="1" id="submitApisKey" name="submitApisKey"
					class="btn btn-default pull-right">

					<i class="process-icon-save"></i> {l s='Guardar' mod='weatherinfo'}

				</button>

			</div>

		</div>
	</div>
</form>