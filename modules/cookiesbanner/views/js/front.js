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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

document.addEventListener('DOMContentLoaded', function() {
    const cookiesBanner = document.querySelector('#cookiesBanner');
    const acceptCookies = document.querySelector('#cookiesAccepted');
    const rejectCookies = document.querySelector('#cookiesRejected');
    const popupOverlay = document.querySelector('.cookies-overlay');

    if (getCookie('consent_cookies') !== '') {
        cookiesBanner.style.display = 'none';
        if (popupOverlay) popupOverlay.style.display = 'none';
        return;
    }

    if (acceptCookies) {
        acceptCookies.addEventListener('click', (e) => {
            e.preventDefault();
            setCookie('consent_cookies', 'accepted', 365);

            cookiesBanner.style.display = 'none';
            if (popupOverlay) popupOverlay.style.display = 'none';
        })
    }

    if (rejectCookies) {
        rejectCookies.addEventListener('click', (e) => {
            e.preventDefault();
            setCookie('consent_cookies', 'rejected', 365);

            cookiesBanner.style.display = 'none';
            if (popupOverlay) popupOverlay.style.display = 'none';
        })
    }

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        const cookieName = name + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const cookieArray = decodedCookie.split(';');
        
        for(let i = 0; i < cookieArray.length; i++) {
            let cookie = cookieArray[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(cookieName) === 0) {
                return cookie.substring(cookieName.length, cookie.length);
            }
        }
        return '';
    }
});