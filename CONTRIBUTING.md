# Contributing to Window Cleaning Cost Calculator

Thanks for your interest in contributing! This project is maintained by [Binx Professional Cleaning](https://www.binx.ca/).

## Getting Started

1. Fork the repository
2. Create a feature branch: `git checkout -b my-feature`
3. Make your changes
4. Run tests for both engines:
   - Python: `cd engines/python && pytest`
   - Rust: `cd engines/rust && cargo test`
5. Commit your changes: `git commit -m "Add my feature"`
6. Push to your fork: `git push origin my-feature`
7. Open a pull request

## Guidelines

- Both calculation engines (Python and Rust) must produce identical output for the same inputs. If you change the calculation logic, update both engines.
- Include tests for any new functionality.
- Keep the PHP frontend simple — no JavaScript frameworks.
- All monetary values are in CAD.

## Reporting Issues

Open an issue on GitHub with a clear description of the bug or feature request. Include steps to reproduce if reporting a bug.

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
