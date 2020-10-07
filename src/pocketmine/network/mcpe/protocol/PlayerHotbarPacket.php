<?php

namespace pocketmine\mcpe\network\protocol;

use pocketmine\network\mcpe\protocol\types\ContainerIds;

class PlayerHotbarPacket extends DataPacket {

	const NETWORK_ID = ProtocolInfo::PLAYER_HOTBAR_PACKET;

	public $selectedHotbarSlot;
	public $windowId = ContainerIds::INVENTORY;
	public $selectHotbarSlot = true;

	public function decode() {
		$this->selectedHotbarSlot = $this->getUnsignedVarInt();
		$this->windowId = $this->getByte();
		$count = $this->getUnsignedVarInt();
		for ($i = 0; $i < $count; ++$i) {
			$this->slots[$i] = Binary::signInt($this->getUnsignedVarInt());
		}
		$this->selectHotbarSlot = $this->getBool();
	}

	public function encode() {
		$this->putUnsignedVarInt($this->selectedHotbarSlot);
		$this->putByte($this->windowId);
		$this->putUnsignedVarInt(count($this->slots));
		foreach ($this->slots as $slot) {
			$this->putUnsignedVarInt($slot);
		}
		$this->putBool($this->selectHotbarSlot);
	}

}
