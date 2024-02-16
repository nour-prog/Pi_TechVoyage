# Pi_TechVoyage

### Installing

1. **Clone the repository** to your local machine:

    ```bash
    git clone <repository-url> -b <branch-name>
    ```

2. **Install dependencies**:

    ```bash
    cd <project-directory>
    composer install
    ```

3. **Set up your environment variables**:

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database configuration.

4. **Set up the database**:

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5. **Start the Symfony development server**:

    ```bash
    symfony server:start
    ```