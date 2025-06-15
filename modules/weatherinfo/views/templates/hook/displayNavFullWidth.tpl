{if $data_weather.cod != 404}
    <div class="w-100">
        <div class="weather-block">
            <div class="weather-container">
                <img src="https://openweathermap.org/img/wn/{$weather_icon}@2x.png" alt="weather_icon" width="55">
                <span><strong>{l s='Ubicación: ' mod='weatherinfo'}</strong>{$city}, {$country}. </span>
                <span><strong>{l s='Tiempo actual: ' mod='weatherinfo'}</strong>{$weather}</span>
                <span><strong>{l s='Temperatura: ' mod='weatherinfo'}</strong>{$temp}°C</span>
                <span><strong>{l s='Sensación Térmica: ' mod='weatherinfo'}</strong>{$feels_like}°C</span>
                <span><strong>{l s='Humedad: ' mod='weatherinfo'}</strong>{$humidity}%</span>
            </div>

        </div>
    </div>
{/if}