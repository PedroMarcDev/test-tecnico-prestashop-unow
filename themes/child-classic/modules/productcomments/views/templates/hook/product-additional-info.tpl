{**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

{if $post_allowed}
  <div class="product-comments-additional-info d-flex align-items-center">
    <div class="additional-links d-flex">
      {include file='module:productcomments/views/templates/hook/average-grade-stars.tpl' grade=$average_grade}
      <a class="link-comment btn btn-sm pl-0 pr-1" href="#product-comments-list-header">
        {if $nb_comments != 0}
          {l s='Ver la opinión' d='Modules.Productcomments.Shop'}
        {else}
          {l s='No hay opiniones de momento' d='Modules.Productcomments.Shop'}
        {/if}
      </a>
    </div>
    <div id="rating-snippets">
        <span class="average-rating">{l s='Valoración media:' d='Modules.Productcomments.Shop'} {$average_grade}/5</span>
        <span class="total-reviews">{l s='Nº valoraciones:' d='Modules.Productcomments.Shop'} {$nb_comments}</span>
    </div>

    {* Rich snippet rating*}
    <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
      <meta itemprop="reviewCount" content="{$nb_comments}" />
      <meta itemprop="ratingValue" content="{$average_grade}" />
    </div>
  </div>
{/if}