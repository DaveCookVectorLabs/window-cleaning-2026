project = 'Window Cleaning Cost Calculator'
copyright = '2026, Binx Professional Cleaning'
author = 'Binx Professional Cleaning'
release = '0.1.0'

extensions = []

templates_path = ['_templates']
exclude_patterns = ['_build']

html_theme = 'sphinx_rtd_theme'
html_static_path = ['_static']
html_show_sourcelink = False

html_context = {
    'display_github': True,
    'github_user': 'DaveCookVectorLabs',
    'github_repo': 'window-cleaning-2026',
    'github_version': 'main',
    'conf_py_path': '/docs/',
}
