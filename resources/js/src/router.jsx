import { createBrowserRouter } from 'react-router-dom';
import Home from './pages/Home';
import Options from './pages/Options';
import Faults from './pages/Faults';
import Tests from './pages/Tests';
import Chat from './pages/Chat';

const router = createBrowserRouter([
    {
        path: '/app',
        element: <Home />,
    },
    {
        path: '/app/options',
        element: <Options />,
    },
    {
        path: '/app/faults',
        element: <Faults />,
    },
    {
        path: '/app/tests',
        element: <Tests />,
    },
    {
        path: '/app/chat',
        element: <Chat />,
    }
]);

export default router;
