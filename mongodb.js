add to github

/*
CODESCHOOL FREE WEEKEND
MONGO DB
*/


/* Increment count field by 1 */
db.logs.update(
  {name:"Dream Bender"},
  {"$inc":{count:1}},
  {upsert:true}
)


/* Unset all smell fields */
db.wands.update(
  {},
  {$unset:{smell:""}},
  {"multi": true}
)

/* Set value within specific array */
db.wands.update(
  {"name": "Dream Bender"},
  {$set:{"powers.0":"Fire Deflection"}}
)


/* Set all within array regardless of where it is */
db.wands.update(
  {"powers": "Love"},
  {$set:{"powers.$":"Love Burst"}},
  {"multi": true}
)



/* Add to an array */
db.wands.update(
  {"name": "Dream Bender"},
  {$push:{powers:"Spell Casting"}}
)


/*add value to array in all docs within the collection only if value does not already exist */
db.wands.update(
  {},
  {$addToSet:{powers:"Spell Casting"}},
  {"multi": true}
)




/*Multiply a value */
db.wands.update(
  {},
  {$mul:{"damage.melee":10}},
  {multi: true}
)



/* query operators less than equal to */
db.wands.find(
  {level_required:{$lte:5}}
)


/* greater than equal to and less than equal to */
db.wands.find(
  {"damage.melee":{$gte:30, $lte:40}}
)


/* find specific values within an array */
db.wands.find(
  {lengths:{$elemMatch:{$gte:2.5, $lt:3}}}
)



db.wands.find(
  {
  	maker:{$ne:"Foxmond"},
  level_required:{$lte:75},
   price:{$lt:50},
   lengths:{$elemMatch:{$gte:3, $lte:4}}
  }
)


/*Find and display only the field you want */
db.wands.find(
  {},  
  {name:true}
)


/*Find and sort*/
db.wands.find({}, {"name": true}).sort({"name": 1})


/*exclude fields from return */
db.wands.find({},{price:false,lengths:false,_id:false} )

/*exclude and include fields */
db.wands.find({},{name:true,powers:true,price:false,lengths:false,_id:false} )

/*find and count */
db.wands.find({"level_required":2}).count()

/*so only 8 wands return*/
db.wands.find({}).skip(0).limit(8)


/* find and sort price descending */
db.wands.find().sort({"price":-1})

/* find, sort descending and limit */
db.wands.find().sort({"price":-1}).limit(3)

/* 
EMBEDDING 
Best fit for storing users and their addresses when we know that the data is used together
often, won't be changing regularly, and each user will only be storing a few addresses.

When we take the data from one document and place it inside another one, that's called an 
embedded document.  Embedding gives us all the data we need with a single query, support
for atomic writes, and is great for data that is strongly related */

 /*If we take a unique value like an _id from one document and store it as a value within
a related document, we have just created a referenced document.  Doesn't have default support
for atomic writes across multiple documents and should be utilized with care  */






































