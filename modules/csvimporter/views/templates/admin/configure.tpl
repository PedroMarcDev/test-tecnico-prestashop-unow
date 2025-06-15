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

<div class="panel">
	<h3><i class="icon-cogs"></i> {l s='Importador de productos por CSV' mod='productsimporter'}</h3>

	<form class="defaultForm form-horizontal" id="form_prod" action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label class="control-label col-lg-3" for="csv_product">{l s='Adjunta un archivo CSV para la importación' mod='productsimporter'}</label>
			<div class="col-lg-9">
				<input type="file" id="csv_product" name="csv_product">
				<p class="help-block small">{l s='Formato recomendado para el archivo: .csv' mod='productsimporter'}</p>
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-9 col-lg-offset-3">
				<button type="submit" id="submit_csv" name="submit_csv" class="btn btn-primary">
					{l s='Cargar CSV' mod='importproducts'}
				</button>
			</div>
		</div>
	</form>
</div>