

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;

// Charger les drivers nécessaires
DriverManager::loadDriver(\BotMan\Drivers\Discord\DiscordDriver::class);

return [
    // Configurations pour Discord (ajoutez d'autres configurations au besoin)
    'discord' => [
        'token' => 'VOTRE_TOKEN_DISCORD',
    ],
    
    // Configurations générales
    'botman' => [
        'conversation_cache_time' => 40,
    ],
];
