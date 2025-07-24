<div class="panel">
    <h3><i class="icon icon-cloud"></i> Paramétrage météo</h3>
    <form method="post" action="">
        <div class="form-group">
            <label> Rentrez votre clé API OpenWeatherMap</label>
            <input type="text" name="EXERCICEDASHBOARD_API_KEY" class="form-control" value="{$api_key|escape:'html':'UTF-8'}" required>
        </div>

        <div class="form-group">
            <label>Ville</label>
            <input type="text" name="EXERCICEDASHBOARD_CITY" class="form-control" value="{$city|escape:'html':'UTF-8'}" required>
        </div>

        <button type="submit" name="submit_exercicedashboard_config" class="btn btn-primary">
            <i class="icon-save"></i> Enregistrer
        </button>
    </form>
</div>
