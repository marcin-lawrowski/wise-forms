<?php

/**
 * WiseForms encryption support.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsCrypt {
	const KEY_BITS = 512;

	const PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAK8ZNPswYNogqXKX+CJrxQdCN6oYXWjz
MoOpgOGr8Nyg7qm0Yamuv3zXU4xcU8puYHE1pKChIkmybGD896zpxG8CAwEAAQ==
-----END PUBLIC KEY-----';

	const PRIVATE_KEY = '-----BEGIN PRIVATE KEY-----
MIIBVAIBADANBgkqhkiG9w0BAQEFAASCAT4wggE6AgEAAkEArxk0+zBg2iCpcpf4
ImvFB0I3qhhdaPMyg6mA4avw3KDuqbRhqa6/fNdTjFxTym5gcTWkoKEiSbJsYPz3
rOnEbwIDAQABAkBrLLCjN39wxCEzhRVabECTKtLLiFJUlNdMg4nhl868G7j8X3yn
wxBGNGe9sRbaLllHso568vtcMtP3oOkDRrBBAiEA57Z1spk6bHiKAxTUPn220WB/
UcG5s9G/AUo4InAfJnECIQDBc55NZt2szQFym+cRDdXz1XOlOYq9d8VduPah7S/I
3wIgc+lCV2VvZHOoFoKE6f3ZRkQPbMaMLvftpKeMDS4pZwECIQC5z/kctZJ1GVCr
qg3u9pAsLjlvWW7nADUGCdRzwmQklwIgDMk3gCi6l1lzhsl7Qvax3L0mL4E+FycW
zJ7aKDAJ17Q=
-----END PRIVATE KEY-----';

	/**
	 * Encrypts given data.
	 *
	 * @param string $data
	 *
	 * @return string
	 */
	public static function encrypt($data) {
		// add unique salt to the data:
		$data = self::getSalt().'|'.$data;

		$chunkSize = ceil(self::KEY_BITS / 8) - 11;
		$encryptedOutput = '';

		while (strlen($data) > 0) {
			$chunk = substr($data, 0, $chunkSize);
			$data = substr($data, $chunkSize);
			$encrypted = '';
			openssl_public_encrypt($chunk, $encrypted, self::PUBLIC_KEY);
			$encryptedOutput .= $encrypted;
		}

		return $encryptedOutput;
	}

	/**
	 * Decrypts given data.
	 *
	 * @param string $data
	 *
	 * @return string
	 */
	public static function decrypt($data) {
		$privKey = self::PRIVATE_KEY;

		$chunkSize = ceil(self::KEY_BITS / 8);
		$decryptedOutput = '';
		while (strlen($data) > 0) {
			$chunk = substr($data, 0, $chunkSize);
			$data = substr($data, $chunkSize);
			$decrypted = '';
			openssl_private_decrypt($chunk, $decrypted, $privKey);
			$decryptedOutput .= $decrypted;
		}

		// verify salt at the begining of the decrypted data:
		$pipePosition = strpos($decryptedOutput, '|');
		$actualSalt = substr($decryptedOutput, 0, $pipePosition);
		if ($actualSalt === self::getSalt()) {
			return substr($decryptedOutput, $pipePosition + 1);
		}

		return null;
	}

	/**
	 * Returns unique salt for WordPress installation.
	 *
	 * @return string
	 */
	private static function getSalt() {
		return wp_hash('g61,WlG-L]9/50i)  W+@m=B?1-gL|{$q@bDJUMzGeHP?C?uDq:##8WD7?6Leulm');
	}
}