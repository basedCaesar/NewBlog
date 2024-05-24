# Use the official Node.js image with the specific version
FROM node:18.17.1

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

RUN if [ -f $ROOT/package-lock.json ]; \
    then \
    npm ci --no-optional --loglevel=error --no-audit; \
    else \
    npm install --no-optional --loglevel=error --no-audit; \
    fi

# Install dependencies
RUN npm install

# Copy the rest of the application
COPY . .

# Expose port 8080 (or whatever port your app runs on)
EXPOSE 8080

# Start the application
CMD ["npm", "run", "dev"]
