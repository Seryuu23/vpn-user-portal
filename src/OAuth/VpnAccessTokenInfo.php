<?php

declare(strict_types=1);

/*
 * eduVPN - End-user friendly VPN.
 *
 * Copyright: 2016-2019, The Commons Conservancy eduVPN Programme
 * SPDX-License-Identifier: AGPL-3.0+
 */

namespace LC\Portal\OAuth;

use fkooman\OAuth\Server\AccessTokenInfo;
use fkooman\OAuth\Server\Scope;

class VpnAccessTokenInfo extends AccessTokenInfo
{
    /** @var bool */
    private $isLocal;

    public function __construct(string $userId, string $clientId, Scope $scope, bool $isLocal)
    {
        parent::__construct($userId, $clientId, $scope);
        $this->isLocal = $isLocal;
    }

    public function getIsLocal(): bool
    {
        return $this->isLocal;
    }
}
