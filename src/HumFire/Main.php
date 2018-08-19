<?php

namespace HumFire;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{

private $lightning;

    public function onEnable(){
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
}

    public function addStrike(Player $p, $boolHere){
        if( $boolHere == true){
          $level = $p->getLevel();
          $light = new AddEntityPacket();
          $light->type = 93;
          $light->entityRuntimeId = Entity::$entityCount++;
          $light->metadata = array();
          $light->position = $p->asVector3()->add(0,$height = 0);
          $light->yaw = $p->getYaw();
          $light->pitch = $p->getPitch();
          $p->getServer()->broadcastPacket($level->getPlayers(),$light); 

        }
    }
    
    public function onJoin(PlayerJoinEvent $event){
        $p = $event->getPlayer();
        $this->addStrike($p, true);
    }
    
    public function onDeath(PlayerDeathEvent $event){
        $p = $event->getPlayer();
        $this->addStrike($p, true);
    }
    
    public function onTap(PlayerInteractEvent $event){
      $item = $event->getItem();
      if($item->getCustomName() === "Lightning"){
        $this->addStrike($event->getPlayer(), true);
      }
    }
}
