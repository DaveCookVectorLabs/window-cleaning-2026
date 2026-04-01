Getting Started
===============

Requirements
------------

- PHP 8.1+ with a web server (Apache or Nginx)
- Python 3.10+ (for the Python engine)
- Rust 1.70+ and Cargo (for the Rust engine)
- Docker (optional — for containerized deployment)

Quick Start
-----------

Clone the repository and start the PHP frontend with the Python engine:

.. code-block:: bash

   git clone https://github.com/DaveCookVectorLabs/window-cleaning-2026.git
   cd window-cleaning-2026

   # Start the Python engine
   cd engines/python
   pip install -r requirements.txt
   python engine.py

   # In a second terminal, start the PHP frontend
   cd public/
   php -S localhost:8000

Open ``http://localhost:8000`` in your browser.

Docker
------

The Python engine is available as a Docker container:

.. code-block:: bash

   docker pull davecook1985/window-cleaning-2026:latest
   docker run -p 8001:8001 davecook1985/window-cleaning-2026

The engine listens on port 8001 and exposes two endpoints:

- ``POST /calculate`` — returns a detailed cost breakdown as JSON
- ``GET /health`` — health check

Installation from Package Registries
-------------------------------------

**npm:**

.. code-block:: bash

   npm install @davecook/window-cleaning-2026

**PyPI:**

.. code-block:: bash

   pip install window-cleaning-2026
