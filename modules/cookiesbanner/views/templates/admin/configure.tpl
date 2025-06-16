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
	<div class="panel-heading">
		<i class="icon-cog"></i> {l s='Configurar banner de cookies' mod='cookiesbanner'}
	</div>

	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Título del banner' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="text" name="banner_title" id="banner_title" value="{$title}">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Color del título' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="color" name="banner_title_color" id="banner_title_color" value="{$title_color}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Contenido del banner' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<textarea name="banner_content" id="banner_content">{$content}</textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Color del texto' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="color" name="banner_text_color" id="banner_text_color" value="{$txt_color}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Fondo del banner' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="color" name="banner_background_color" id="banner_background_color" value="{$bg_color}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Botón de aceptar cookies' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="text" name="accept_btn_txt" id="accept_btn_txt" value="{$txt_btn_accept}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Botón de rechazar cookies' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="text" name="refuse_btn_txt" id="refuse_btn_txt" value="{$txt_btn_refuse}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Color texto "Aceptar cookies"' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="color" name="accept_text_color" id="accept_text_color" value="{$accept_txt_color}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Color texto "Rechazar cookies"' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="color" name="refuse_text_color" id="refuse_text_color" value="{$refuse_txt_color}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Color botón "Aceptar cookies"' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="color" name="accept_bg_color" id="accept_bg_color" value="{$accept_bg_color}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Color botón "Rechazar cookies"' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<input type="color" name="refuse_bg_color" id="refuse_bg_color" value="{$refuse_bg_color}" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Posición del banner' mod='cookiesbanner'}
			</label>
			<div class="col-lg-9">
				<select name="banner_position" id="banner_position" class="fixed-width-xl">
					<option value="top" {if $banner_position == 'top'}selected="selected" {/if}>
						{l s='Superior' mod='cookiesbanner'}
					</option>
					<option value="bottom" {if $banner_position == 'bottom'}selected="selected" {/if}>
						{l s='Inferior' mod='cookiesbanner'}
					</option>
					<option value="popup" {if $banner_position == 'popup'}selected="selected" {/if}>
						{l s='Popup' mod='cookiesbanner'}
					</option>
				</select>
			</div>
		</div>

		<div class="panel-footer">
			<button type="submit" value="1" id="submitBannerConfig" name="submitBannerConfig"
				class="btn btn-default pull-right">
				<i class="process-icon-save"></i> {l s='Guardar' mod='cookiesbanner'}
			</button>
		</div>
	</form>
</div>