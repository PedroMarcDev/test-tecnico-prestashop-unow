{if $banner_position == 'popup'}
    <div class="cookies-overlay"></div>
{/if}

<div class="cookies-banner {$banner_position}" id="cookiesBanner" style="background: {$bg_color};">
    <h3 class="cookies-banner-title" style="color: {$title_color};">{$title}</h3>
    <p class="cookies-banner-content" style="color: {$txt_color};">{$content}</p>
    
    <div class="cookies-buttons">
        <button class="accept-cookies cookies-banner-btn" id="cookiesAccepted" style="color: {$accept_txt_color}; background: {$accept_bg_color}">
            {$txt_btn_accept}
        </button>
        <button class="refuse-cookies cookies-banner-btn" id="cookiesRejected" style="color: {$refuse_txt_color}; background: {$refuse_bg_color}">
            {$txt_btn_refuse}
        </button>
    </div>
</div>