import { createBrowserRouter } from 'react-router-dom';
import Home from './pages/Home';
import Options from './pages/Options';
import Faults from './pages/Faults';
import Tests from './pages/Tests';
import Chat from './pages/Chat';

const router = createBrowserRouter([
    {
        path: '/dashboard',
        element: <Home />,
    },
    {
        path: '/dashboard/options',
        element: <Options />,
    },
    {
        path: '/dashboard/faults',
        element: <Faults />,
    },
    {
        path: '/dashboard/tests',
        element: <Tests />,
    },
    {
        path: '/dashboard/chat',
        element: <Chat />,
    }
]);

export default router;
