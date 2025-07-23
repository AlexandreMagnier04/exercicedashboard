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

        $this->displayName = $this->trans('Weather module', [], 'Modules.ExerciceDashboard.Admin');
        $this->description = $this->trans('Add widget weather to the homepage of back office.', [], 'Modules.ExerciceDashboard.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.1.0', 'max' => _PS_VERSION_];

        $this->templateFile = 'module:exercicedashboard/views/templates/hook/exercicedashboard.tpl';
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('dashboardZoneOne');
    }
    public function uninstall()
    {
        return parent::uninstall() &&
            $this->unregisterHook('dashboardZoneOne');
    }

    #Afficher sur le dashboard
    public function hookDashboardZoneOne()
    {
       $temp = $this->callApi();
      $this->context->smarty->assign([
            'temp' => $temp['temp'] ?? null,
            'city' => $temp['city'] ?? null,
        ]);
        return $this->fetch($this->templateFile);

    }

    #Connexion à l'API OpenWeatherMap
    protected function callApi()
    {
        $keyApi = 'f2ecb01dca04faddc02b46914de93be8';
        $city = 'Paris';
        $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($city) . '&appid=' . $keyApi . '&units=metric';
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'Content-Type: application/json',
            ],
        ]);

        $response = file_get_contents($url, false, $context);
        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);
        if (isset($data['main']['temp'], $data['name'])) {
            return [
                'temp' => $data['main']['temp'],
                'city' => $data['name']
            ];
        }

        return false;
    }
}
