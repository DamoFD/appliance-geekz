import { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext();

export const useAuth = () => {
    return useContext(AuthContext);
}

export const AuthProvider = ({ children }) => {
    const [token, setToken] = useState(window.AccessToken);
    const [user, setUser] = useState(window.user);

    useEffect(() => {
        if (token) {
            localStorage.setItem('ACCESS_TOKEN', token);
        } else {
            localStorage.removeItem('ACCESS_TOKEN');
        }
    }, [token]);

    const contextValue = {
        token,
        setToken,
        user,
        setUser,
    };

    return <AuthContext.Provider value={contextValue}>{children}</AuthContext.Provider>;
}
