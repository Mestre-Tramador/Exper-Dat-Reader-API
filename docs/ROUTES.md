# Exper-Dat-Reader API Routes

Currently there are **2** working routes on the API.

## Auth

The Exper-Dat-Reader API works with a simple HTTP Basic Auth.  
Currently the one valid user are the one provided on the `.env` file, so the
given username and password should match the **`AUTH_USER`** and **`AUTH_PW`**,
as follows the example:

```ini
AUTH_USER=example-user
AUTH_PW=example-psw
```

## Routes

The API base path is **`api/`**.  
Below are the routes of the Exper-Dat-Reader API:

### Dump and Processed Data Routes

These routes are designed solely to obtain values already decrypted and mainly dumped.

#### Main Dump `GET`

`/dat/done`

This route brings the head dump file data.

##### Response

It is an array with four fields, which indexes follows:

- **0**: Clients count;
- **1**: Sellers count;
- **2**: Best Buy ID;
- **3**: Worst Seller Name.

The `JSON` can come with the default values if there is no dumped data:

```json
[0, 0, null, null]
```

### Util Routes

These routes are designed to obtain misc data and execute some other tasks.

#### Dat Files Count `GET`

`/dat/total`

This route brings the count of no decrypted `.dat` files.

##### Response

| **Field** | **Type** |                   **Description**                  |
|:---------:|:--------:|:--------------------------------------------------:|
| *count*   | `number` | The current quantity of no decrypted `.dat` files. |

An example:

```json
{ "count": 0 }
```
