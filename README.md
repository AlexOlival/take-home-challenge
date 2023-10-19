# take-home-challenge

## backend
The backend uses Laravel Sail to set up (with a lot of the 'fat' trimmed off - I only needed Redis)

Simply `cd` into the directory and run `./vendor/bin/sail up`

The rest should be pretty standard - however be sure to set the correct env variables `PORT` `CLIENT_ORIGIN_URL` `AUTH0_AUDIENCE` and `AUTH0_DOMAIN` as per what is required for Auth0 to work

## frontend
`cd` into the directory and run `docker compose up`. You may want to change the port depending on your needs (I ran the frontend app on 9000)

If you do change the port, be sure to also check `vite.config.ts` and update the `server` config object accordingly

Then, create a `auth_config.json` file (I have included an `auth_config_example.json` file which you can copy) - you should set the `domain`, `clientId` and `audience` values as per what is required for Auth0 to work

Finally, simply access the Docker container and run `npm install` and then `npm run dev`

You should then be able to run the project!
