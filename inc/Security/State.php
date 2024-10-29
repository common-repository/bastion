<?php
namespace Bastion\Security;

class State {

	protected $empty_credentials = false;

	public function is_empty_credentials(): bool {
		return $this->empty_credentials;
	}

	public function set_empty_credentials( bool $empty_credentials ): void {
		$this->empty_credentials = $empty_credentials;
	}
}
