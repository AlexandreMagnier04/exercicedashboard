<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class ExerciceDashboard extends Module
{
    protected $templateFile;
    public function __construct()
    {
        $this->name = ('exercicedashboard');
        $this->author = ('AlexandreMagnier');
        $this->version = ('1.0.0');
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('exercicedashboard', [], 'Modules.ExerciceDashboard.Admin');
        $this->description = $this->trans('Add widget weather to the homepage of back office.', [], 'Modules.ExerciceDashboard.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.1.0', 'max' => _PS_VERSION_];

        $this->templateFile = 'module:exercicedashboard/views/templates/hook/exercicedashboard.tpl';
    }

    #Installation du module
    public function install()
    {
        return parent::install() &&
            $this->registerHook('dashboardZoneOne') &&
            Configuration::updateValue('EXERCICEDASHBOARD_API_KEY', '') &&
            Configuration::updateValue('EXERCICEDASHBOARD_CITY', 'Paris') &&
            Configuration::updateValue('EXERCICEDASHBOARD_DATA_WEATHER', '') &&
            Configuration::updateValue('EXERCICEDASHBOARD_UPDATE', 'manual') &&
            $this->registerHook('actionCronJob');
    }

    #Désinstallation du module
    public function uninstall()
    {
        return parent::uninstall() &&
            $this->unregisterHook('dashboardZoneOne') &&
            Configuration::deleteByName('EXERCICEDASHBOARD_API_KEY') &&
            Configuration::deleteByName('EXERCICEDASHBOARD_CITY') &&
            Configuration::deleteByName('EXERCICEDASHBOARD_DATA_WEATHER') &&
            Configuration::deleteByName('EXERCICEDASHBOARD_UPDATE');
    }

    #Configuration du module
    public function getContent()
    {
        if (Tools::isSubmit('submit_exercicedashboard_config')) {
            Configuration::updateValue('EXERCICEDASHBOARD_API_KEY', Tools::getValue('EXERCICEDASHBOARD_API_KEY'));
            Configuration::updateValue('EXERCICEDASHBOARD_CITY', Tools::getValue('EXERCICEDASHBOARD_CITY'));
            Configuration::updateValue('EXERCICEDASHBOARD_UPDATE', Tools::getValue('EXERCICEDASHBOARD_UPDATE'));

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminDashboard'));
        }
        return $this->renderConfigForm();
    }

    #Formulaire de configuration
    protected function renderConfigForm()
    {
        $this->context->smarty->assign([
            'api_key' => Configuration::get('EXERCICEDASHBOARD_API_KEY'),
            'city' => Configuration::get('EXERCICEDASHBOARD_CITY'),
            'update' => Configuration::get('EXERCICEDASHBOARD_UPDATE'),

        ]);

        return $this->fetch('module:exercicedashboard/views/templates/admin/config_form.tpl');
    }

    #Afficher sur le dashboard
    public function hookDashboardZoneOne()
    {
        $update = Configuration::get('EXERCICEDASHBOARD_UPDATE');

        if ($update === 'manual' && Tools::isSubmit('update_weather')) {
            $this->updateWeatherData();
        }
        $weatherData = Configuration::get('EXERCICEDASHBOARD_DATA_WEATHER');
        $weatherData = $weatherData ? json_decode($weatherData, true) : $this->updateWeatherData();

        $this->context->smarty->assign([
            'city' => Configuration::get('EXERCICEDASHBOARD_CITY'),
            'temp' => $weatherData['main']['temp'] ?? null,
            'desc' => $weatherData['weather'][0]['description'] ?? null,
            'icon' => $weatherData['weather'][0]['icon'] ?? null,
            'update' => $update,
        ]);
        return $this->fetch($this->templateFile);
    }

    #Connexion à l'API OpenWeatherMap
    protected function callApi()
    {
        $apiKey = Configuration::get('EXERCICEDASHBOARD_API_KEY');
        $city = Configuration::get('EXERCICEDASHBOARD_CITY');

        if (!$apiKey || !$city) {
            return null;
        }

        $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric&lang=fr";


        try {
            $response = file_get_contents($url);
            return json_decode($response, true);
        } catch (Exception $e) {
            return null;
        }
    }

    protected function updateWeatherData()
    {
        $data = $this->callApi();

        if ($data) {
            Configuration::updateValue('EXERCICEDASHBOARD_DATA_WEATHER', json_encode($data));
        }

        return $data;
    }

    public function hookActionCronJob()
    {
        if (Configuration::get('EXERCICEDASHBOARD_UPDATE') === 'auto') {
            $this->updateWeatherData();
        }
    }

}
