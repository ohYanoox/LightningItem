<?php

namespace Yanoox\Events;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use Yanoox\Data\PoolData;
use Yanoox\loader;

class eventListener extends PoolData implements Listener{

    public function onHit(EntityDamageByEntityEvent $ev){
        $victim = $ev->getEntity();
        $damager = $ev->getDamager();
        $cfg = loader::getConfigFile();
        if ($damager instanceof Player && $victim instanceof Player){
            if ($damager->getInventory()->getItemInHand()->getId() == $cfg->get("id") && $damager->getInventory()->getItemInHand()->getMeta() == $cfg->get("meta"))
            {
                if (!$this->hasCooldown($damager)){
                    $this->addCooldown($damager);
                    if ($cfg->get("percentage_bool") === true){
                        $rand = mt_rand(1, 100);
                        if($rand <= $cfg->get("percentage")){
                            $this->spawnLigthningBolt($victim, $damager);
                            return;
                        }
                        else{
                            if (loader::getConfigFile()->get("message") === true){
                                $damager->sendMessage(loader::getConfigFile()->get("appearance_failure"));
                            }
                            if (loader::getConfigFile()->get("popup") === true){
                                $damager->sendPopup(loader::getConfigFile()->get("appearance_failure"));
                            }
                            return;
                        }
                    }
                    $this->spawnLigthningBolt($victim, $damager);
                }
                else{
                    if (time() > $this->getCooldown($damager)){
                        $this->rmCooldown($damager);
                    }
                }
            }
        }
    }

    /**
     * $victim will be used to apply a position to lightning
     * $damager will be used to send a message (or not) to the damager
     *
     * @param Player $victim
     * @param Player $damager
     * @return void
     */
    public function spawnLigthningBolt(Player $victim, Player $damager) {
        $sound = new PlaySoundPacket();
        $sound->soundName = "ambient.weather.lightning.impact";
        $sound->volume = 1;
        $sound->pitch = 1;
        $sound->x = $victim->getPosition()->x;
        $sound->y = $victim->getPosition()->y;
        $sound->z = $victim->getPosition()->z;

        $bolt = new AddActorPacket();
        $bolt->type = "minecraft:lightning_bolt";
        $bolt->actorRuntimeId = $bolt->actorUniqueId = Entity::nextRuntimeId();
        $bolt->position = $victim->getPosition();

        $victim->getPosition()->getWorld()->broadcastPacketToViewers($victim->getPosition()->asVector3(), $bolt);
        if (loader::getConfigFile()->get("damage_bool") === true){
            $victim->attack(new EntityDamageEvent($victim, EntityDamageEvent::CAUSE_ENTITY_ATTACK, loader::getConfigFile()->get("damage")));
        }
        $victim->getPosition()->getWorld()->broadcastPacketToViewers($victim->getPosition()->asVector3(), $sound);

        if (loader::getConfigFile()->get("message") === true){
            $damager->sendMessage(loader::getConfigFile()->get("appearance_success"));
        }
        if (loader::getConfigFile()->get("popup") === true){
            $damager->sendPopup(loader::getConfigFile()->get("appearance_success"));
        }
    }
}
