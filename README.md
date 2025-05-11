# BD Addresses

A comprehensive collection of Bangladeshi addresses data, including a PHP form and API for easy integration.

## Features

- **Bangladeshi Addresses Data**: A complete dataset of divisions, districts, upazilas, and post offices in Bangladesh.
- **PHP Form**: A user-friendly form to select and manage addresses.
- **API**: A simple API to fetch address data programmatically.

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/bd_addresses.git
   ```
2. **Move into the project directory:**
   ```bash
   cd bd_addresses
   ```
3. **Set up your web server:**
   - Place the project in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Ensure PHP is installed and running.

## Usage

### Data

- The addresses data is available in the `data/` directory in JSON format.
- Files include:
  - `bd-divisions.json`: List of all divisions.
  - `bd-districts.json`: List of all districts.
  - `bd-upazilas.json`: List of all upazilas.
  - Individual district files (e.g., `1.json`, `2.json`, etc.) containing post office data.

### PHP Form

- Open `address-form.php` in your browser to use the address form.
- The form allows you to select a division, district, upazila, and post office, and enter a village/mahalla.

### API

- Use `api.php` to access the API endpoints:
  - `api.php?action=divisions`: Returns all divisions.
  - `api.php?action=districts&division_id=<id>`: Returns districts for a specific division.
  - `api.php?action=upazilas&district_id=<id>`: Returns upazilas for a specific district.
  - `api.php?action=postoffices&district_id=<id>`: Returns post offices for a specific district.

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.