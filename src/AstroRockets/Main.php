<?php

declare(strict_types=1);

namespace TurtleSh0ck\AstroRockets;


use pocketmine\item\ItemIds;
use pocketmine\level\Position;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Item\item;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerInteractEvent;


class Main extends PluginBase implements Listener {

    public function onEnable()
    {
        $this->getServer()->getLogger()->info(TF::GREEN . "AstroRockets made by TurtleSh0ck was successfully enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {

            case "ar":
                if ($sender instanceof Player) {
                  if (!$sender->hasPermission("ar.cmd")) {
                      $sender->sendMessage(TF::RED . "You do not have permission to use this command.");
						return false;
					}
                    if (empty($args[0])) {
                        $sender->sendMessage(TF::RED . "Usage: /ar give (player) (amount)");
                        return true;
                    }
                    switch ($args[0]) {
                        case "give":
                            if (empty($args[1])) {
                                $sender->sendMessage(TF::RED . "Usage: /ar give (player) (amount)");
                                return true;
                            }
                            $player = $this->getServer()->getPlayer($args[1]);
                            if ($player === null) {
                                $sender->sendMessage(TF::RED . "Player is offline");
                                return true;
                            }
                            $fireworks = Item::get(Item::FIREWORKS);
                            $fireworks->setCustomName(TF::RED . "§lPiffi's Rocket");
                            $fireworks->setLore([TF::GREEN . "Use to boost urself into the sky!"]);
                            $nbt = $fireworks->getNamedTag();
							$nbt->setString("astrorockets", 'mhm', true);
							$fireworks->setCompoundTag($nbt);
                            if (empty($args[2])) {
                                $sender->sendMessage(TF::RED . "Usage: /ar give (player) (amount)");
                                return true;
                            }
                            for ($count = $args[2] ?? 1; $count > 0; --$count) {
                                $player->getInventory()->addItem(clone $fireworks); 
     
                            }
                    }
                }
        }
        return true;
    }

         public function onInteract(PlayerInteractEvent $event) {
         if($event->getItem()->getId() === 401) {
         $player = $event->getPlayer();	
         $item = $player->getInventory()->getItemInHand();
		 if ($item->getId() == 0) {
			return;
		}
		 if(!$item->getNamedTag()->hasTag("astrorockets", StringTag::class)) {
			return;
		}
         $player->setMotion(new Vector3(0, 1, 0));
         $inv = $player->getInventory();
         $item = $inv->getItemInHand();
         $item->count--;
         $inv->setItemInHand($item);
     
         
        }                   
    }
}
