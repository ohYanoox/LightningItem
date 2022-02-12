# LightningItem
**LightningItem is a PocketMine-MP 4.0.0 plugin that inflicted damage on the attacked player thanks to the appearance of a lightning bolt.**

## SETUP
**Only put the api in the src of your plugin and use it :)**

## How to use ?

you have at your disposal a config where you can customize from A to Z (I think :')) the plugin
```YAML
#The item that will make the lightning appear
id: 1
meta: 0

#Cooldown between the time the player receives a blow before a lightning bolt appears (in seconds)
cooldown: 5

#if true, then the lightning will appear in relation to the percentage of chance (in seconds)
percentage_bool: true
percentage: 50

#if true, then the lightning will inflict x damage on the attacked player
damage_bool: true
damage: 1

#Choose under what circumstances the player will be notified when lightning appears
message: false
popup: true

#some message :')
appearance_success: "Lightning appears :)"
appearance_failure: "no luck :'("
```


## There you go!
have a nice day ;)
