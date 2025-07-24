<div class="panel">
    <h3>Météo à {$city}</h3>
    {if $icon}
        <img src="https://openweathermap.org/img/wn/{$icon}@2x.png" alt="{$desc}">
    {/if}
    <p><strong>Température :</strong> {$temp} °C</p>
    <p><strong>Description :</strong> {$desc}</p>

    {if $update == 'manual'}
    <form method="post">
        <input type="hidden" name="update_weather" value="1">
        <button type="submit" class="btn btn-primary">Mettre à jour maintenant</button>
    </form>
    {/if}
</div>
