<div class="row">
    <div class="col-xs-12">
        <div class="weather-container">
            <img src="https://openweathermap.org/img/wn/{$weather_icon}@2x.png" alt="weather_icon" width="55">
            <span><strong>{l s='Ubicacion: ' mod='weatherbyuserip'}</strong>{$city}, {$country}. </span>
            <span><strong>{l s='Tiempo actual: ' mod='weatherbyuserip'}</strong>{$weather}</span>
            <span><strong>{l s='Temperatura: ' mod='weatherbyuserip'}</strong>{$temp}°C</span>
            <span><strong>{l s='Sensacion Termica: ' mod='weatherbyuserip'}</strong>{$feels_like}°C</span>
            <span><strong>{l s='Humedad: ' mod='weatherbyuserip'}</strong>{$humidity}%</span>
        </div>

    </div>
</div>