<?php

namespace Yanoox\Data;

use pocketmine\Player\player;
use Yanoox\loader;

class PoolData{

    public array $cooldown;

    public function addCooldown(Player $player){
        if (!isset($this->cooldown[$player->getName()])){
            $this->cooldown[$player->getName()] = time() + loader::getConfigFile()->get("cooldown");
        }
    }

    public function getCooldown(Player $player){
        return $this->cooldown[$player->getName()];
    }

    public function rmCooldown(Player $player){
        if (isset($this->cooldown[$player->getName()])){
            unset($this->cooldown[$player->getName()]);
        }
    }

    public function hasCooldown(Player $player): bool
    {
       return isset($this->cooldown[$player->getName()]);
    }
}
