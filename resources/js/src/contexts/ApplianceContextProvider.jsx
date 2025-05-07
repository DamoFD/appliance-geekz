import { createContext, useContext, useState } from 'react';

const ApplianceContext = createContext();

export const useAppliance = () => {
    return useContext(ApplianceContext);
}

export const ApplianceProvider = ({ children }) => {
    const [appliance, setAppliance] = useState({
        brand: '',
        model: '',
        serial: '',
    });

    const contextValue = {
        appliance,
        setAppliance
    };

    return <ApplianceContext.Provider value={contextValue}>{children}</ApplianceContext.Provider>;
}
