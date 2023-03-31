the project

a project to get internet packages from provider and sell them to users with discount


### first step
get packages from the provider and store them in database

<p>
what we need of internet package to store: 

title, 
description, 
price, 
provider_identifier,
duration,
traffic
</p>

done+

### second step
buy packages from provider and store the result in database

<p>
what we need to store these for the user =>
api_order_id, status, package_id, user_id
</p>

done+

### third step
get user wallet_amount and check it can buy package or not

<p>
if wallet amount is less than package price it will throw error 
otherwise it will buy the package
</p>

done+

### step 4
update user wallet amount after payment successes
<p>
consider so many requests per user (we give them api)
</p>
done+
