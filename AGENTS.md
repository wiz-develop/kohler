# Environment-specific source rules

This repository uses `main` for production and `test` for the test environment.

## Production-only Meta Pixel

- The block between `PRODUCTION ONLY: Meta Pixel Code` and `END PRODUCTION ONLY: Meta Pixel Code` in `header.php` is production-only.
- Keep Meta Pixel ID `1044493571917966` in `main`; do not add it to `test`.
- Never replace the production `header.php` with the test version. Promote tested changes by merging `test` into `main`, and preserve the production-only block while resolving conflicts.
- Do not duplicate, move, or silently change the production-only block or Pixel ID.
- Before completing any production change, run `./scripts/verify-environment-head.sh production`.
- Before completing any test-environment change, run `./scripts/verify-environment-head.sh test`.

See `docs/deployment-rules.md` for the release procedure.
