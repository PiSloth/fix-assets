<center>Welcome dude</center>
<br />

## For what?

First POS system and later enhance to be a ERP.

## Need to edit
- item location display

//invoice table edited to enum

payment function level one

### tiny editions
- [x] delete constrained branch and category [Completed]

- [x] Permission control
- [x] Product Photo change
- [ ] Changed photo remained in preview, need to clear it
- [ ] Product Delete // product cascade delete need on branch product
- [ ] Sale invoice cancle
- [ ] Permission ui changing
- [ ] Product search bar in porducts
- [ ] Daily sale summary is not contain cancled vouchers
- [ ] Sale Dashboard

```php
public function update(Request $request, Product $product)
{
    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust as needed
    ]);

    if ($request->hasFile('photo')) {
        // Get old photo path
        $oldPhoto = $product->photo;

        // Store the new photo
        $newPhotoPath = $request->file('photo')->store('products', 'public');

        // Update product record with new photo
        $product->update(['photo' => $newPhotoPath]);

        // Delete old photo if it exists
        if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
            Storage::disk('public')->delete($oldPhoto);
        }
    }

    return back()->with('success', 'Product photo updated successfully.');
}

```


### version history
- dmk' 1.0.1
  ```text
    basic usage with manual inventory adjustment
  ```
  ***
- dmk' 1.0.2
  ```text
    accounting basic add like coa, general ledger
  ```
  1. invoice table change with 'date' field added, 'discount' field added
   
***

### Server Changes
- dmk' 1.0.2
  
```eloquent
    table->foreignId('product_id')->constrained()->cascadeOnDelete()
```
Purpose is when delete product, relative branch product must delete. But if sale item exist, this function will not allow.
