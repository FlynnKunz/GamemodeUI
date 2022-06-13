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

use Vecnavium\FormsUI\SimpleForm;

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
	            $prefix = $this->config->get("Prefix");
                    $player->setGamemode(GameMode::SURVIVAL());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.survival"));
                break;
                
                case 1:
	            $prefix = $this->config->get("Prefix");
	            $player->setGamemode(GameMode::CREATIVE());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.creative"));
                break;
                
                case 2:
	            $prefix = $this->config->get("Prefix");
                    $player->setGamemode(GameMode::ADVENTURE());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.adventure"));
                break;
                
                case 3:
	            $prefix = $this->config->get("Prefix");
                    $player->setGamemode(GameMode::SPECTATOR());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.spectator"));
                break;
            }
        });
        $form->setTitle($this->config->getNested("GamemodeUI.title"));
        $form->setContent($this->config->getNested("GamemodeUI.content"));
        $form->addButton($this->config->getNested("GamemodeUI.button-survival"));
        $form->addButton($this->config->getNested("GamemodeUI.button-creative"));
        $form->addButton($this->config->getNested("GamemodeUI.button-adventure"));
        $form->addButton($this->config->getNested("GamemodeUI.button-spectator"));
        $form->addButton($this->config->getNested("GamemodeUI.button-exit"));
        $player->sendForm($form);
    }
}
