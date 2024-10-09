-- Check All Orders and Their Status
SELECT o.OrderID, o.CustomerID, c.Name, o.CollectionID, col.Name AS ProductName, o.OrderDate, o.Status
FROM cj_streetwear.order o
JOIN cj_streetwear.customer c ON o.CustomerID = c.CustomerID
JOIN cj_streetwear.collectionlist col ON o.CollectionID = col.CollectionID
ORDER BY o.OrderDate DESC;

-- View Total Inventory per Product
SELECT col.Name AS ProductName, i.StockLevel, i.Status
FROM cj_streetwear.inventory i
JOIN cj_streetwear.collectionlist col ON i.CollectionID = col.CollectionID
ORDER BY col.Name;

-- List All Transactions for a Specific Customer
SELECT t.TransactionID, t.OrderID, t.PaymentMethod, t.PaymentDetails, t.Timestamp
FROM cj_streetwear.transaction t
JOIN cj_streetwear.order o ON t.OrderID = o.OrderID
JOIN cj_streetwear.customer c ON o.CustomerID = c.CustomerID
WHERE c.CustomerID = 1  -- Change '1' to the specific customer ID
ORDER BY t.Timestamp DESC;

-- Get Orders and Their Corresponding Shipping Details
SELECT o.OrderID, o.CustomerID, c.Name, s.ShippingCost, s.DeliveryTime, s.CustomerLocation, s.Status AS ShippingStatus
FROM cj_streetwear.order o
JOIN cj_streetwear.customer c ON o.CustomerID = c.CustomerID
JOIN cj_streetwear.shippinganddelivery s ON o.OrderID = s.OrderID
ORDER BY s.DeliveryTime DESC;

-- Check Refunds for Specific Orders
SELECT r.RefundID, r.OrderID, r.ReturnReason, r.RefundStatus
FROM cj_streetwear.refund r
JOIN cj_streetwear.order o ON r.OrderID = o.OrderID
JOIN cj_streetwear.customer c ON o.CustomerID = c.CustomerID
WHERE c.CustomerID = 1  -- Change '1' to the specific customer ID
ORDER BY r.RefundID DESC;