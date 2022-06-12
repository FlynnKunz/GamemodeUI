<?php
declare(strict_types=1);

namespace FlynnKunz\GamemodeUI;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\task\scheduler\Task;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use FormAPI\{CustomForm, SimpleForm};

class Main extends PluginBase {
    
    public function onEnable() : void{
    	$this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
    }

    public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {
        
        if($cmd->getName() == "gamemodeui"){
            $this->gmdUI($sender);
        }
        
        return true;
    }
    
    public function gmdUI($player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            $target = $player->getName();
            switch($data){
                case 0:
                    $this->getServer()->getCommandMap()->dispatch($player, "gamemode survival");
                    $player->sendMessage("§fChanged gamemode to §aSurvival§fmode");
                break;
                
                case 1:
				    $this->getServer()->getCommandMap()->dispatch($player, "gamemode c");
                    $player->sendMessage("§fChanged gamemode to §cCreative §fmode");
                break;
                
                case 2:
                    $this->getServer()->getCommandMap()->dispatch($player, "gamemode adventure");
                    $player->sendMessage("§fChanged gamemode to §bAdventure §fmode");
                break;
                
                case 3:
                     $this->getServer()->getCommandMap()->dispatch($player, "gamemode 3");
                    $player->sendMessage("§fChanged gamemode to §eSpectator §fmode");
                break;
            }
        });
        $form->setTitle($this->config->get("title"));
        $form->setContent($this->config->get("content"));
        $form->addButton("§l§cSurvival\n§rTap To Change");
        $form->addButton("§l§aCreative\n§rTap To Change");
        $form->addButton("§l§bAdventure\n§rTap To Change");
        $form->addButton("§l§eSpectator\n§rTap To Change");
        $form->addButton("§l§cEXIT\n§rTap To Exit");
        $form->sendToPlayer($player);
        return $form;
    }
}
