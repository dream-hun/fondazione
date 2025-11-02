<?php

declare(strict_types=1);

use Laravel\Mcp\Facades\Mcp;

// Mcp::web('/mcp/demo', \App\Mcp\Servers\PublicServer::class);

Mcp::web('/mcp/filament-docs', App\Mcp\Servers\FilamentMcpServer::class);
