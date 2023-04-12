the project

a project to get internet packages from provider and sell them to users with discount

## second phase

#### step 1
add fixed units for traffic and duration of packages
+done


#### step 2
add operator's identifiers for each package
<br />
(mci, irancell, rightel)

#### step 3
add discounts per each operator packages

#### step 4
provide a list of packages

#### step 5
provide an api to get order details (status and package)

#### step 6 
add authorization for users and admin

#### step 7
add register with phone number (with sms confirmation)

#### step 8
add functionality to ban users from admin side

#### step 9
add functionality to update user's wallet amount from admin side


<br />
<br />

## first phase:

#### first step
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

#### second step
buy packages from provider and store the result in database

<p>
what we need to store these for the user =>
api_order_id, status, package_id, user_id
</p>
done+

#### third step
get user wallet_amount and check it can buy package or not

<p>
if wallet amount is less than package price it will throw error 
otherwise it will buy the package
</p>
done+


#### step 4
update user wallet amount after payment successes
<p>
consider so many requests per user (we give them api)
</p>
done+

#### step 5
admin can add discount for internet packages
done+
