<?php


namespace imasterprox\iHello;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\player;
use pocketmine\command\Command;

class iHello extends PluginBase implements Listener {

    /** @var Config */
    private $config;

    public function  onEnable() {
        $this->config = new Config($this->getDataFolder() . "test.json", Config::YAML , [
                "Join" => "어서오세요"
        ]);
        $this->join = $this->config->getAll();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onPlayerJoin(PlayerJoinEvent $event) {
        $event->getPlayer()->sendMessage($this->join["Join"]);
        return true;
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        if($cmd == "입장메세지"){
            if(! isset($args[0])){
                $sender->sendMessage("메세지를입력해주세요");
                return true;
            }
            $this->join["Join"] = $args[0];
            $sender->sendMessage("변경되었습니다.\n변경된메세지 : {$this->join["Join"]}");
            $this->onSave();
            return true;
        }
    }
    public function onSave() {
        $this->config->setAll($this->join);
        $this->config->save();
    }

}
