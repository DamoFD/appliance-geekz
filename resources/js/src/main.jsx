import React from 'react';
import ReactDOM from 'react-dom/client';
import { RouterProvider } from 'react-router-dom';
import router from './router';
import { AuthProvider } from './contexts/AuthContextProvider';
import { ApplianceProvider } from './contexts/ApplianceContextProvider';

document.getElementById('loading').style.display = 'none';

ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        <AuthProvider>
            <ApplianceProvider>
                <RouterProvider router={router} />
            </ApplianceProvider>
        </AuthProvider>
    </React.StrictMode>
)
