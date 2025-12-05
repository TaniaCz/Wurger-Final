import { createContext, useContext, useState, useEffect } from 'react';

const CartContext = createContext();

export const CartProvider = ({ children }) => {
    const [cart, setCart] = useState([]);
    const [userId, setUserId] = useState(null);

    useEffect(() => {
        const storedUser = localStorage.getItem('usuario');
        if (storedUser) {
            const user = JSON.parse(storedUser);
            setUserId(user.id);
            const storedCart = localStorage.getItem(`cart_${user.id}`);
            if (storedCart) {
                setCart(JSON.parse(storedCart));
            } else {
                setCart([]);
            }
        } else {
            setUserId(null);
            setCart([]);
        }
    }, []);

    useEffect(() => {
        if (userId) {
            localStorage.setItem(`cart_${userId}`, JSON.stringify(cart));
        }
    }, [cart, userId]);

    // Listen for login/logout changes
    useEffect(() => {
        const handleStorageChange = () => {
            const storedUser = localStorage.getItem('usuario');
            if (storedUser) {
                const user = JSON.parse(storedUser);
                if (user.id !== userId) {
                    setUserId(user.id);
                    const storedCart = localStorage.getItem(`cart_${user.id}`);
                    setCart(storedCart ? JSON.parse(storedCart) : []);
                }
            } else {
                setUserId(null);
                setCart([]);
            }
        };

        window.addEventListener('storage', handleStorageChange);
        // Custom event for same-tab login/logout
        window.addEventListener('user-login', handleStorageChange);

        return () => {
            window.removeEventListener('storage', handleStorageChange);
            window.removeEventListener('user-login', handleStorageChange);
        };
    }, [userId]);

    const addToCart = (product) => {
        setCart((prevCart) => {
            const existingItem = prevCart.find((item) => item.id === product.id);
            if (existingItem) {
                return prevCart.map((item) =>
                    item.id === product.id
                        ? { ...item, quantity: item.quantity + 1 }
                        : item
                );
            }
            return [...prevCart, { ...product, quantity: 1 }];
        });
    };

    const removeFromCart = (productId) => {
        setCart((prevCart) => prevCart.filter((item) => item.id !== productId));
    };

    const updateQuantity = (productId, quantity) => {
        if (quantity < 1) return;
        setCart((prevCart) =>
            prevCart.map((item) =>
                item.id === productId ? { ...item, quantity } : item
            )
        );
    };

    const clearCart = () => {
        setCart([]);
    };

    const getCartTotal = () => {
        return cart.reduce((total, item) => total + item.precio * item.quantity, 0);
    };

    return (
        <CartContext.Provider
            value={{
                cart,
                addToCart,
                removeFromCart,
                updateQuantity,
                clearCart,
                getCartTotal,
            }}
        >
            {children}
        </CartContext.Provider>
    );
};

export const useCart = () => useContext(CartContext);
