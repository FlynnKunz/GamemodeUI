<?php
declare(strict_types=1);

namespace FlynnKunz\GamemodeUI;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\player\GameMode;

use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\task\scheduler\Task;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use FlynnKunz\GamemodeUI\FormAPI\{CustomForm, SimpleForm};

class Main extends PluginBase {
	
    public Config $config;
    
    public function onEnable() : void{
    	$this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml");
	$this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {
        
        if($cmd->getName() == "gamemodeui"){
            $this->gmdUI($sender);
        }
        
        return true;
    }
    
    public function gmdUI(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            $target = $player->getName();
            switch($data){
                case 0:
                    $player->setGamemode(GameMode::SURVIVAL());
                    $player->sendMessage("Changed gamemode to Survival mode");
                break;
                
                case 1:
	            $player->setGamemode(GameMode::CREATIVE());
                    $player->sendMessage("Changed gamemode to Creative mode");
                break;
                
                case 2:
                    $player->setGamemode(GameMode::ADVENTURE());
                    $player->sendMessage("Changed gamemode to Adventure mode");
                break;
                
                case 3:
                     $player->setGamemode(GameMode::SPECTATOR());
                    $player->sendMessage("Changed gamemode to Spectator mode");
                break;
            }
        });
        $form->setTitle($this->config->get("title"));
        $form->setContent($this->config->get("content"));
        $form->addButton("Survival\nTap To Change");
        $form->addButton("Creative\nTap To Change");
        $form->addButton("Adventure\nTap To Change");
        $form->addButton("Spectator\nTap To Change");
        $form->addButton("EXIT\nTap To Exit");
        $form->sendToPlayer($player);
        return $form;
    }
}
