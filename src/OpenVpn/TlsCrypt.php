<?php

declare(strict_types=1);

/*
 * eduVPN - End-user friendly VPN.
 *
 * Copyright: 2016-2019, The Commons Conservancy eduVPN Programme
 * SPDX-License-Identifier: AGPL-3.0+
 */

namespace LC\Portal\OpenVpn;

use LC\Portal\FileIO;
use ParagonIE\ConstantTime\Hex;
use RuntimeException;

class TlsCrypt
{
    /** @var string */
    private $tlsCrypt;

    public function __construct(string $tlsCrypt)
    {
        if (false === strpos($tlsCrypt, '2048 bit OpenVPN static key')) {
            throw new RuntimeException('provided string is not an OpenVPN static key');
        }
        $this->tlsCrypt = $tlsCrypt;
    }

    public static function fromFile(string $tlsCryptFile): self
    {
        return new self(FileIO::readFile($tlsCryptFile));
    }

    public static function generate(): self
    {
        // Same as $(openvpn --genkey --secret <file>)
        $randomData = wordwrap(Hex::encode(random_bytes(256)), 32, "\n", true);
        $tlsCrypt = <<< EOF
#
# 2048 bit OpenVPN static key
#
-----BEGIN OpenVPN Static key V1-----
$randomData
-----END OpenVPN Static key V1-----

EOF;

        return new self($tlsCrypt);
    }

    public function raw(): string
    {
        return $this->tlsCrypt;
    }
}
