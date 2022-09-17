<?php

namespace SlaxxyQC\StaffKick; 

use pocketmune\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use jojoe77777\FormAPI\CustomForm;

class Main extends PluginBase{
    
    public function onEnable(): void{
        $this->getLogger()->info("StaffKick By SlaxxyQC");
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        switch($cmd->getName()){
            case"staffkick":
                if($sender instanceof Player){
                    $this->onKickMute($sender);
                }else{
                    $sender->sendMessage("Cette command est dispoible juste ig-game !");
                }
            break;
        }
        return true;
    }
    
    public function onKickMute(Player $player){
        $list = [];
        foreach($this->getServer()->getOnlinePlayers() as $p) {
           $list[] = $p->getName();
        }
        $this->players[$player->getName()] = $list;
        $form = new CustomForm(function (Player $player, array $data = null){
            if($data === null){
                $this->openTools($player);
            return true;
            }
            $index = $data[0];
            $reason = $data[1];
            $name = $this->players[$player->getName()][$index];
            $sender = $player->getServer()->getPlayerByPrefix($name);
            $sender->Kick($reason);
        
        });
        $form->setTitle("§6StaffMenu");
        $form->addDropdown("§dSélectionée un Joueur", $this->players[$player->getName()]);
	    $form->addInput("§6Raison du Kick", "Ex: Insulte");
        $form->sendToPlayer($player);
        return $form;
    }
}