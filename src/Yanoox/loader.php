<?php
/*
__    __      ___   __   _   _____   _____  __    __
\ \  / /     /   | |  \ | | /  _  \ /  _  \ \ \  / /
 \ \/ /     / /| | |   \| | | | | | | | | |  \ \/ /
  \  /     / / | | | |\   | | | | | | | | |   }  {
  / /     / /  | | | | \  | | |_| | | |_| |  / /\ \
 /_/     /_/   |_| |_|  \_| \_____/ \_____/ /_/  \_\

Plugin's name: LightningItem
Author: Yanoox
Plugin's version: 0.1
Plugin's api: 4.0.0
For: everyone
 */
namespace Yanoox;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Yanoox\Events\eventListener;

class loader extends PluginBase{

    public static loader $instance;

    public function onEnable() : void
    {
        self::$instance = $this;
        $this->initResources();
        $this->getServer()->getPluginManager()->registerEvents(new eventListener(), $this);
     
        $this->getLogger()->info("§3|━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━|");
        $this->getLogger()->info("§3|The LightningItem plugin is loaded|");
        $this->getLogger()->info("§3|━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━|");
    }

    public static function getInstance() : loader
    {
        return self::$instance;
    }

    public static function getConfigFile() : Config{
        return new Config(self::getInstance()->getDataFolder() . "config.yml", Config::YAML);
    }

    public function initResources(): bool
    {
        @mkdir($this->getDataFolder());
        @$this->saveResource("config.yml");
        if (!file_exists($this->getDataFolder() . "config.yml")) {
            $this->getLogger()->error("Cannot get the config file : config.yml");
            return false;
        }

        return true;
    }

    public function onLoad() : void
    {
        $this->saveConfig();
    }
}


