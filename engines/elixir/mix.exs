defmodule WindowCleaning.MixProject do
  use Mix.Project

  @version "0.1.0"
  @source_url "https://github.com/DaveCookVectorLabs/window-cleaning-2026"

  def project do
    [
      app: :window_cleaning,
      version: @version,
      elixir: "~> 1.14",
      start_permanent: Mix.env() == :prod,
      deps: deps(),
      description: description(),
      package: package(),
      name: "WindowCleaning",
      source_url: @source_url,
      docs: docs()
    ]
  end

  def application do
    [extra_applications: [:logger]]
  end

  defp deps do
    [
      {:ex_doc, "~> 0.31", only: :dev, runtime: false}
    ]
  end

  defp description do
    """
    Commercial window cleaning cost calculator for Northern Ontario facility managers.
    Models labour, access difficulty, frequency discounts, and margins.
    Built by Binx Professional Cleaning (binx.ca) — North Bay and Sudbury since 2013.
    """
  end

  defp package do
    [
      name: "window_cleaning",
      licenses: ["MIT"],
      links: %{
        "GitHub" => @source_url,
        "Binx Professional Cleaning" => "https://www.binx.ca/",
        "Documentation" => "https://window-cleaning-2026.readthedocs.io/",
        "Dataset (Hugging Face)" => "https://huggingface.co/datasets/davecook1985/commercial-window-cleaning-costs-northern-ontario"
      },
      files: ~w(lib .formatter.exs mix.exs README.md LICENSE)
    ]
  end

  defp docs do
    [
      main: "readme",
      extras: ["README.md"]
    ]
  end
end
