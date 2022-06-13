<?php
declare(strict_types=1);

namespace FlynnKunz\GamemodeUI;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\player\GameMode;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;

use pocketmine\plugin\PluginBase;

use Vecnavium\FormsUI\SimpleForm;
# PluginUtils by fernanACM
use FlynnKunz\GamemodeUI\utils\PluginUtils;

class Main extends PluginBase {
	
    public Config $config;
    
    public function onEnable() : void{
    	  $this->saveResource("config.yml");
          $this->config = new Config($this->getDataFolder() . "config.yml");
	  $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch ($command->getName()) {
            case "gamemodeui":
                if($sender instanceof Player) {
                           $this->gmdUI($sender);
                           PluginUtils::PlaySound($sender, "random.chestopen", 1, 1);
                     } else {
                             $sender->sendMessage("Use this command in-game");
                              return true;
                     }
            break;
        }
        return true;
    }
    
    public function gmdUI(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null){
                return true;
            }
            switch($data){
                case 0:
	             $prefix = $this->config->get("Prefix");
                    $player->setGamemode(GameMode::SURVIVAL());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.survival"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;
                
                case 1:
	                $prefix = $this->config->get("Prefix");
	                $player->setGamemode(GameMode::CREATIVE());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.creative"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;
                
                case 2:
	                $prefix = $this->config->get("Prefix");
                    $player->setGamemode(GameMode::ADVENTURE());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.adventure"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;
                
                case 3:
	               $prefix = $this->config->get("Prefix");
                    $player->setGamemode(GameMode::SPECTATOR());
                    $player->sendMessage($prefix . $this->config->getNested("Messages.spectator"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;
                    
                case 4:
                    PluginUtils::PlaySound($player, "random.pop2", 1.5, 3.4);
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
