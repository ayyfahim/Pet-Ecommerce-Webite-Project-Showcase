FROM node:16-alpine

#RUN npm --location=global config set user node
#
#USER node
#
#RUN mkdir /home/node/.npm-global
#RUN mkdir /home/node/app
#ENV PATH=/home/node/.npm-global/bin:$PATH
#ENV NPM_CONFIG_PREFIX=/home/node/.npm-global

RUN npm install npm@latest --location=global

# install pnpm
RUN npm i --location=global pnpm
WORKDIR /home/node/app
COPY --chown=node:node package.json pnpm-lock.yaml .npmrc ./

RUN pnpm install

COPY --chown=node:node . .

EXPOSE 3000

CMD ["pnpm", "start"]
