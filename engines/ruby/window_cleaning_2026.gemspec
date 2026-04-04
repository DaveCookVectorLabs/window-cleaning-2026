Gem::Specification.new do |s|
  s.name        = "window_cleaning_2026"
  s.version     = "0.1.0"
  s.summary     = "Commercial window cleaning cost calculator for Northern Ontario facility managers"
  s.description = "A lightweight cost-estimation engine for commercial window cleaning jobs. " \
                  "Models labour rates, access-method difficulty (ground level, ladder, boom lift, " \
                  "rope access, swing stage), service scope, cleaning frequency discounts, materials " \
                  "surcharge, and profit margins. Built by Binx Professional Cleaning — a WSIB-covered, " \
                  "fully insured commercial and residential cleaning company operating in North Bay " \
                  "and Sudbury, Northern Ontario since 2013."
  s.authors     = ["Dave Cook"]
  s.email       = "dave@binx.ca"
  s.homepage    = "https://github.com/DaveCookVectorLabs/window-cleaning-2026"
  s.license     = "MIT"
  s.files       = Dir["lib/**/*.rb"] + ["README.md", "LICENSE"]
  s.require_paths = ["lib"]
  s.required_ruby_version = ">= 2.7.0"

  s.metadata = {
    "homepage_uri"      => "https://github.com/DaveCookVectorLabs/window-cleaning-2026",
    "source_code_uri"   => "https://github.com/DaveCookVectorLabs/window-cleaning-2026/tree/main/engines/ruby",
    "documentation_uri" => "https://window-cleaning-2026.readthedocs.io/",
    "bug_tracker_uri"   => "https://github.com/DaveCookVectorLabs/window-cleaning-2026/issues",
  }
end
