# Pokemon API Proxy

Serwis REST API służący do agregowania informacji o Pokemonach. Aplikacja pośredniczy w komunikacji z zewnętrznym PokeAPI, umożliwiając jednocześnie zarządzanie lokalną listą "zbanowanych" Pokemonów.

## Wymagania

- PHP >= 8.2
- Composer
- Baza danych (domyślnie skonfigurowane pod MySQL)

## Instalacja i uruchomienie

Poniższe kroki przedstawiają proces instalacji aplikacji od zera.

1. **Sklonowanie repozytorium**
   ```bash
   git clone https://github.com/ksmialowski/pokemonApp
   cd <katalog_projektu>
   ```

2. **Instalacja zależności**
   ```bash
   composer install
   ```

3. **Konfiguracja środowiska**
   Należy skopiować plik przykładowy `.env.example` na `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Generowanie klucza aplikacji**
   ```bash
   php artisan key:generate
   ```

5. **Migracja tabel do bazy danych**
   ```bash
   php artisan migrate
   ```

6. **Uruchomienie serwera**
   ```bash
   php artisan serve
   ```
   Serwis będzie dostępny pod adresem: `http://localhost:8000`.
