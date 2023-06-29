<?php

declare(strict_types=1);

namespace FlynnKunz\GamemodeUI;

use pocketmine\player\Player;
use pocketmine\player\GameMode;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;

use pocketmine\plugin\PluginBase;

use Vecnavium\FormsUI\SimpleForm;
# PluginUtils by fernanACM
use FlynnKunz\GamemodeUI\utils\PluginUtils;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

    /** @var Config $config */
    public Config $config;

    /**
     * @return void
     */
    public function onEnable(): void{
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder(). "config.yml");
    }

    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param string $label
     * @param array $args
     * @return boolean
     */
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch($command->getName()){
            case "gamemodeui":
                if($sender instanceof Player){
                    $this->gmUI($sender);
                    PluginUtils::PlaySound($sender, "random.chestopen", 1, 1);
                }else{
                    $sender->sendMessage("Use this command in-game");
                }
            break;
        }
        return true;
    }

    /**
     * @param Player $player
     * @return void
     */
    public function gmUI(Player $player): void{
        $form = new SimpleForm(function(Player $player, $data){
            if(is_null($data)){
                PluginUtils::PlaySound($player, "random.chestclosed", 1, 1);
                return true;
            }
            switch($data){
                case 0: // SURVIVAL
                    if(!$player->hasPermission("gamemodeui.survival")){
                        $player->sendMessage($this->Prefix(). $this->config->getNested("NoPermissionMessages.survival"));
                        return;
                    }
                    $player->setGamemode(GameMode::SURVIVAL());
                    $player->sendMessage($this->Prefix() . $this->config->getNested("Messages.survival"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;

                case 1: // CREATIVE
                    if(!$player->hasPermission("gamemodeui.creative")){
                        $player->sendMessage($this->Prefix(). $this->config->getNested("NoPermissionMessages.creative"));
                        return;
                    }
                    $player->setGamemode(GameMode::CREATIVE());
                    $player->sendMessage($this->Prefix() . $this->config->getNested("Messages.creative"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;

                case 2: // ADVENTURE
                    if(!$player->hasPermission("gamemodeui.adventure")){
                        $player->sendMessage($this->Prefix(). $this->config->getNested("NoPermissionMessages.adventure"));
                        return;
                    }
                    $player->setGamemode(GameMode::ADVENTURE());
                    $player->sendMessage($this->Prefix() . $this->config->getNested("Messages.adventure"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;

                case 3: // SPECTATOR
                    if(!$player->hasPermission("gamemodeui.spectator")){
                        $player->sendMessage($this->Prefix(). $this->config->getNested("NoPermissionMessages.spectator"));
                        return;
                    }
                    $player->setGamemode(GameMode::SPECTATOR());
                    $player->sendMessage($this->Prefix() . $this->config->getNested("Messages.spectator"));
                    PluginUtils::PlaySound($player, "random.pop", 1, 1);
                break;

                case 4:
                    PluginUtils::PlaySound($player, "random.chestclosed", 1, 1);
                break;
            }
        });
        $form->setTitle($this->config->getNested("GamemodeUI.title"));
        $form->setContent($this->config->getNested("GamemodeUI.content"));
        $form->addButton($this->config->getNested("GamemodeUI.button-survival"),0,"textures/ui/regeneration_effect");
        $form->addButton($this->config->getNested("GamemodeUI.button-creative"),0,"textures/ui/icon_best3");
        $form->addButton($this->config->getNested("GamemodeUI.button-adventure"),0,"textures/ui/icon_book_writable");
        $form->addButton($this->config->getNested("GamemodeUI.button-spectator"),0,"textures/ui/friend_glyph_desaturated");
        $form->addButton($this->config->getNested("GamemodeUI.button-exit"),0,"textures/ui/cancel");
        $player->sendForm($form);
    }

    /**
     * @return string
     */
    public function Prefix(): string{
        return TextFormat::colorize($this->config->get("Prefix"));
    }
}