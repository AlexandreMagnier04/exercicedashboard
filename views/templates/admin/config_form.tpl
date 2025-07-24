<div class="panel">
    <h3><i class="icon icon-cloud"></i> Paramétrage météo</h3>
    <form method="post" action="">
        <div class="form-group">
            <label> Rentrez votre clé API OpenWeatherMap</label>
            <input type="text" name="EXERCICEDASHBOARD_API_KEY" class="form-control" value="{$api_key|escape:'html':'UTF-8'}" required>
        </div>

    <div class="form-group">
            <label>Mode de mise à jour</label>
            <select name="EXERCICEDASHBOARD_UPDATE class="form-control">
                <option value="manual" {if $update == 'manual'}selected{/if}>Manuelle (bouton)</option>
                <option value="auto" {if $update == 'auto'}selected{/if}>Automatique toutes les 24h</option>
            </select>
        </div>

        <button type="submit" name="submit_exercicedashboard_config" class="btn btn-primary">
            <i class="icon-save"></i> Enregistrer
        </button>
    </form>
</div>
