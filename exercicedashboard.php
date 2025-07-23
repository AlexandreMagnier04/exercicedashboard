<?php

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

    public function hookDashboardZoneOne()
    {
        return 'coucou';
    }

  
}