---
paths:
  - 'app/**/*.php'
---

# App

## Always type-hint closure and arrow function parameters
pest --type-coverage --min=100 is enforced. Every closure/arrow function parameter must have an explicit type. Use Builder for query closures (when(), where()), UploadedFile for file callbacks, and mixed when the input is genuinely untyped (e.g. array_map over a JSON-cast array). Running pest --type-coverage without -d memory_limit=512M will OOM-crash; the composer.json script already sets this.
