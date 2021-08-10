# PHP Diia SDK

<a href="https://packagist.org/packages/sinnrrr/php-laravel-diia"><img src="https://img.shields.io/packagist/dt/sinnrrr/php-diia-sdk" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sinnrrr/php-laravel-diia"><img src="https://img.shields.io/packagist/v/sinnrrr/php-diia-sdk" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sinnrrr/php-laravel-diia"><img src="https://img.shields.io/packagist/l/sinnrrr/php-diia-sdk" alt="License"></a>

## Introduction

The [Diia](https://id.gov.ua/) SDK provides an expressive interface for interacting with [id.gov.ua](https://id.gov.ua/) API and managing branches & offers.

## Documentation

### Installation

To install the SDK in your project you need to require the package via composer:

```bash
composer require sinnrrr/php-diia-sdk
```

### Basic Usage

You can create an instance of the SDK like so:

```php
$diia = new Sinnrrr\Diia\Diia(TOKEN_HERE);
```

Using the `Diia` instance you may perform multiple actions as well as retrieve the different resources Diia's API provides:

```php
$branches = $diia->branches();
```

This will give you an array of branches that you have access to, where each branch is represented by an instance of `Sinnrrr\Diia\Resources\Branch`, this instance has multiple public properties like `$name`, `$email`, `$region`, `$scopes`, and others.

You may also retrieve a single branch using:

```php
$branch = $diia->branch(BRANCH_ID_HERE);
```

On multiple actions supported by this SDK you may need to pass some parameters, for example when creating a new server:

```php
$server = $diia->createServer([
    "provider"=> ServerProviders::DIGITAL_OCEAN,
    "credential_id"=> 1,
    "name"=> "test-via-api",
    "type"=> ServerTypes::APP,
    "size"=> "01",
    "database"=> "test123",
    "database_type" => InstallableServices::POSTGRES,
    "php_version"=> InstallableServices::PHP_71,
    "region"=> "ams2"
]);
```

These parameters will be used in the POST request sent to Forge servers, you can find more information about the parameters needed for each action on
[Forge's official API documentation](https://forge.laravel.com/api-documentation).

Notice that this request for example will only start the server creation process, your server might need a few minutes before it completes provisioning, you'll need to check the server's `$isReady` property to know if it's ready or not yet.

Some SDK methods however waits for the action to complete on Forge's end, we do this by periodically contacting Forge servers and checking if our action has completed, for example:

```php
$diia->createSite(SERVER_ID, [SITE_PARAMETERS]);
```

This method will ping Forge servers every 5 seconds and see if the newly created Site's status is `installed` and only return when it's so, in case the waiting exceeded 30 seconds a `Laravel\Forge\Exceptions\TimeoutException` will be thrown.

You can easily stop this behaviour be setting the `$wait` argument to false:

```php
$diia->createSite(SERVER_ID, [SITE_PARAMETERS], false);
```

You can also set the desired timeout value:

```php
$diia->setTimeout(120)->createSite(SERVER_ID, [SITE_PARAMETERS]);
```

### Authenticated User

```php
$diia->user();
```

### Managing Servers

```php
$diia->servers();
$diia->server($serverId);
$diia->createServer(array $data);
$diia->updateServer($serverId, array $data);
$diia->deleteServer($serverId);
$diia->rebootServer($serverId);

// Server access
$diia->revokeAccessToServer($serverId);
$diia->reconnectToServer($serverId);
$diia->reactivateToServer($serverId);
```

On a `Server` instance you may also call:

```php
$server->update(array $data);
$server->delete();
$server->reboot();
$server->revokeAccess();
$server->reconnect();
$server->reactivate();
$server->rebootMysql();
$server->stopMysql();
$server->rebootPostgres();
$server->stopPostgres();
$server->rebootNginx();
$server->stopNginx();
$server->installBlackfire(array $data);
$server->removeBlackfire();
$server->installPapertrail(array $data);
$server->removePapertrail();
$server->enableOPCache();
$server->disableOPCache();
$server->phpVersions();
$server->installPHP($version);
$server->updatePHP($version);
```

### Server SSH Keys

```php
$diia->keys($serverId);
$diia->sshKey($serverId, $keyId);
$diia->createSSHKey($serverId, array $data, $wait = true);
$diia->deleteSSHKey($serverId, $keyId);
```

On a `SSHKey` instance you may also call:

```php
$sshKey->delete();
```

### Server Scheduled Jobs

```php
$diia->jobs($serverId);
$diia->job($serverId, $jobId);
$diia->createJob($serverId, array $data, $wait = true);
$diia->deleteJob($serverId, $jobId);
```

On a `Job` instance you may also call:

```php
$job->delete();
```

### Server Events

```php
$diia->events();
$diia->events($serverId);
```

### Managing Services

```php
// MySQL
$diia->rebootMysql($serverId);
$diia->stopMysql($serverId);

// Postgres
$diia->rebootPostgres($serverId);
$diia->stopPostgres($serverId);

// Nginx
$diia->rebootNginx($serverId);
$diia->stopNginx($serverId);
$diia->siteNginxFile($serverId, $siteId);
$diia->updateSiteNginxFile($serverId, $siteId, $content);

// Blackfire
$diia->installBlackfire($serverId, array $data);
$diia->removeBlackfire($serverId);

// Papertrail
$diia->installPapertrail($serverId, array $data);
$diia->removePapertrail($serverId);

// OPCache
$diia->enableOPCache($serverId);
$diia->disableOPCache($serverId);
```

### Server Daemons

```php
$diia->daemons($serverId);
$diia->daemon($serverId, $daemonId);
$diia->createDaemon($serverId, array $data, $wait = true);
$diia->restartDaemon($serverId, $daemonId, $wait = true);
$diia->deleteDaemon($serverId, $daemonId);
```

On a `Daemon` instance you may also call:

```php
$daemon->restart($wait = true);
$daemon->delete();
```

### Server Firewall Rules

```php
$diia->firewallRules($serverId);
$diia->firewallRule($serverId, $ruleId);
$diia->createFirewallRule($serverId, array $data, $wait = true);
$diia->deleteFirewallRule($serverId, $ruleId);
```

On a `FirewallRule` instance you may also call:

```php
$rule->delete();
```

### Managing Sites

```php
$diia->sites($serverId);
$diia->site($serverId, $siteId);
$diia->createSite($serverId, array $data, $wait = true);
$diia->updateSite($serverId, $siteId, array $data);
$diia->refreshSiteToken($serverId, $siteId);
$diia->deleteSite($serverId, $siteId);

// Add Site Aliases
$diia->addSiteAliases($serverId, $siteId, array $aliases);

// Environment File
$diia->siteEnvironmentFile($serverId, $siteId);
$diia->updateSiteEnvironmentFile($serverId, $siteId, $content);

// Site Repositories and Deployments
$diia->installGitRepositoryOnSite($serverId, $siteId, array $data, $wait = false);
$diia->updateSiteGitRepository($serverId, $siteId, array $data);
$diia->destroySiteGitRepository($serverId, $siteId, $wait = false);
$diia->siteDeploymentScript($serverId, $siteId);
$diia->updateSiteDeploymentScript($serverId, $siteId, $content);
$diia->enableQuickDeploy($serverId, $siteId);
$diia->disableQuickDeploy($serverId, $siteId);
$diia->deploySite($serverId, $siteId, $wait = false);
$diia->resetDeploymentState($serverId, $siteId);
$diia->siteDeploymentLog($serverId, $siteId);

// PHP Version
$diia->changeSitePHPVersion($serverId, $siteId, $version);

// Installing Wordpress
$diia->installWordPress($serverId, $siteId, array $data);
$diia->removeWordPress($serverId, $siteId);

// Installing phpMyAdmin
$diia->installPhpMyAdmin($serverId, $siteId, array $data);
$diia->removePhpMyAdmin($serverId, $siteId);

// Updating Node balancing Configuration
$diia->updateNodeBalancingConfiguration($serverId, $siteId, array $data);
```

On a `Site` instance you may also call:

```php
$site->refreshToken();
$site->delete();
$site->installGitRepository(array $data, $wait = false);
$site->updateGitRepository(array $data);
$site->destroyGitRepository($wait = false);
$site->getDeploymentScript();
$site->updateDeploymentScript($content);
$site->enableQuickDeploy();
$site->disableQuickDeploy();
$site->deploySite($wait = false);
$site->resetDeploymentState();
$site->siteDeploymentLog();
$site->installWordPress($data);
$site->removeWordPress();
$site->installPhpMyAdmin($data);
$site->removePhpMyAdmin();
$site->changePHPVersion($version);
```

### Site Workers

```php
$diia->workers($serverId, $siteId);
$diia->worker($serverId, $siteId, $workerId);
$diia->createWorker($serverId, $siteId, array $data, $wait = true);
$diia->deleteWorker($serverId, $siteId, $workerId);
$diia->restartWorker($serverId, $siteId, $workerId, $wait = true);
```

On a `Worker` instance you may also call:

```php
$worker->delete();
$worker->restart($wait = true);
```

### Security Rules

```php
$diia->securityRules($serverId, $siteId);
$diia->securityRule($serverId, $siteId, $ruleId);
$diia->createSecurityRule($serverId, $siteId, array $data);
$diia->deleteSecurityRule($serverId, $siteId, $ruleId);
```

On a `SecurityRule` instance you may also call:

```php
$securityRule->delete();
```

### Site Webhooks

```php
$diia->webhooks($serverId, $siteId);
$diia->webhook($serverId, $siteId, $webhookId);
$diia->createWebhook($serverId, $siteId, array $data);
$diia->deleteWebhook($serverId, $siteId, $webhookId);
```

On a `Webhook` instance you may also call:

```php
$webhook->delete();
```

### Site Commands

```php
$diia->executeSiteCommand($serverId, $siteId, array $data);
$diia->listCommandHistory($serverId, $siteId);
$diia->getSiteCommand($serverId, $siteId, $commandId);
```

### Site SSL Certificates

```php
$diia->certificates($serverId, $siteId);
$diia->certificate($serverId, $siteId, $certificateId);
$diia->createCertificate($serverId, $siteId, array $data, $wait = true);
$diia->deleteCertificate($serverId, $siteId, $certificateId);
$diia->getCertificateSigningRequest($serverId, $siteId, $certificateId);
$diia->installCertificate($serverId, $siteId, $certificateId, array $data, $wait = true);
$diia->activateCertificate($serverId, $siteId, $certificateId, $wait = true);
$diia->obtainLetsEncryptCertificate($serverId, $siteId, $data, $wait = true);
```

On a `Certificate` instance you may also call:

```php
$certificate->delete();
$certificate->getSigningRequest();
$certificate->install($wait = true);
$certificate->activate($wait = true);
```
### Nginx Templates

```php
$diia->nginxTemplates($serverId);
$diia->nginxDefaultTemplate($serverId);
$diia->nginxTemplate($serverId, $templateId);
$diia->createNginxTemplate($serverId, array $data);
$diia->updateNginxTemplate($serverId, $templateId, array $data);
$diia->deleteNginxTemplate($serverId, $templateId);
```

On a `NginxTemplate` instance you may also call:

```php
$nginxTemplate->update(array $data);
$nginxTemplate->delete();
```

### Managing Databases

```php
$diia->databases($serverId);
$diia->database($serverId, $databaseId);
$diia->createDatabase($serverId, array $data, $wait = true);
$diia->updateDatabase($serverId, $databaseId, array $data);
$diia->deleteDatabase($serverId, $databaseId);

// Users
$diia->databaseUsers($serverId);
$diia->databaseUser($serverId, $userId);
$diia->createDatabaseUser($serverId, array $data, $wait = true);
$diia->updateDatabaseUser($serverId, $userId, array $data);
$diia->deleteDatabaseUser($serverId, $userId);
```

On a `Database` instance you may also call:

```php
$database->update(array $data);
$database->delete();
```

On a `DatabaseUser` instance you may also call:

```php
$databaseUser->update(array $data);
$databaseUser->delete();
```

### Managing Recipes

```php
$diia->recipes();
$diia->recipe($recipeId);
$diia->createRecipe(array $data);
$diia->updateRecipe($recipeId, array $data);
$diia->deleteRecipe($recipeId);
$diia->runRecipe($recipeId, array $data);
```

On a `Recipe` instance you may also call:

```php
$recipe->update(array $data);
$recipe->delete();
$recipe->run(array $data);
```

### Managing Backups

```php
$diia->backupConfigurations($serverId);
$diia->createBackupConfiguration($serverId, array $data);
$diia->updateBackupConfiguration($serverId, $backupConfigurationId, array $data);
$diia->backupConfiguration($serverId, $backupConfigurationId);
$diia->deleteBackupConfiguration($serverId, $backupConfigurationId);
$diia->restoreBackup($serverId, $backupConfigurationId, $backupId);
$diia->deleteBackup($serverId, $backupConfigurationId, $backupId);
```

On a `BackupConfiguration` instance you may also call:

```php
$extendedConfig = $backupConfig->get(); // Load the databases also
$backupConfig->update(array $data);
$backupConfig->delete();
$backupConfig->restoreBackup($backupId);
$backupConfig->deleteBackup($backupId);
```

On a `Backup` instance you may also call:

```php
$backupConfig->delete();
$backupConfig->restore();
```

## Contributing

Thank you for considering contributing to Forge SDK! You can read the contribution guide [here](.github/CONTRIBUTING.md).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

Please review [our security policy](https://github.com/laravel/forge-sdk/security/policy) on how to report security vulnerabilities.

## License

Laravel Forge SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
